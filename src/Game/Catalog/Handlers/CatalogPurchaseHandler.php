<?php

namespace Emulator\Game\Catalog\Handlers;

use Emulator\Game\GameEnvironmentData;
use Emulator\Game\Catalog\CatalogManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Api\Game\Items\Data\IItemDefinition;
use Emulator\Game\Catalog\Utils\CatalogDiscountData;
use Emulator\Game\Utilities\Handlers\AbstractHandler;
use Emulator\Game\Catalog\Layouts\RecentPurchasesLayout;
use Emulator\Game\Utilities\Handlers\Enums\HandleTypeProcess;
use Emulator\Api\Game\Catalog\Data\{ICatalogPage, ICatalogItem};
use Emulator\Api\Game\Catalog\Providers\IPurchaseProvider;
use Emulator\Game\Catalog\Layouts\{SingleBundleLayout, RoomBundleLayout};
use Emulator\Networking\Outgoing\Alerts\Enums\{AlertPurchaseFailedCode, AlertPurchaseUnavailableCode, GenericErrorCode};
use Emulator\Networking\Outgoing\Alerts\{AlertPurchaseUnavailableComposer, AlertPurchaseFailedComposer, GenericErrorComposer};

class CatalogPurchaseHandler extends AbstractHandler
{
    public function handle(HandleTypeProcess $handleTypeProcess, ...$params): void
    {
        match ($handleTypeProcess) {
            HandleTypeProcess::SingleProcess => $this->handlePurchase(...$params),
            default => $this->getLogger()->warning("Unhandled handle type process.")
        };
    }

    private function handlePurchase(IClient $client, int $pageId, int $itemId, string $extraData, int $amount)
    {
        if(!$this->isValidPurchase($client, $amount, $pageId, $itemId)) return;

        $catalogPage = CatalogManager::getInstance()->getPageById($pageId);

        if(is_null($catalogPage) || !$catalogPage->hasItem($itemId)) {
            $catalogPage = CatalogManager::getInstance()->getPageByItemId($itemId);
        }

        if(!($catalogPage instanceof ICatalogPage)) {
            $client->send(new AlertPurchaseFailedComposer(AlertPurchaseFailedCode::SERVER_ERROR));
            return;
        }

        if($catalogPage->isVipOnly() && $client->getUser()->getData()->getRank() != GameEnvironmentData::$vipRank) {
            $client->getUser()->getLogger()->advertisement("[CAUTION] User tried to purchase a vip item without vip rank. Possible hack attempt.");
            $client->send(new GenericErrorComposer(GenericErrorCode::NEED_TO_BE_VIP));
            return;
        }

        if($catalogPage->getMinRank() > $client->getUser()->getData()->getRank()) {
            $client->getUser()->getLogger()->advertisement("[CAUTION] User tried to purchase an item without the required rank. Possible hack attempt.");
            $client->send(new AlertPurchaseUnavailableComposer(AlertPurchaseUnavailableCode::ILLEGAL_PURCHASE));
            return;
        }

        $catalogItem = $catalogPage->getItemById($itemId);

        if(!($catalogItem instanceof ICatalogItem)) {
            $this->handleItemNotFoundPurchase($client, $catalogPage, $itemId, $amount);
            return;
        }

        if($amount > 1 && !$catalogItem->haveOffer()) {
            $client->getUser()->getLogger()->advertisement("[CAUTION] User tried to purchase an item with an invalid amount. Possible hack attempt.");
            $client->send(new AlertPurchaseUnavailableComposer(AlertPurchaseUnavailableCode::ILLEGAL_PURCHASE));
            return;
        }

        if($client->getUser()->getData()->getRank() < $catalogPage->getMinRank()) {
            $client->send(new AlertPurchaseUnavailableComposer(AlertPurchaseUnavailableCode::ILLEGAL_PURCHASE));
            return;
        }

        $totalCredits = $catalogItem->getCostCredits() * $amount;
        $totalPoints = $catalogItem->getCostPoints() * $amount;

        if($catalogItem->haveOffer()) {
            $totalCredits = $this->calculateItemPriceDiscount($catalogItem->getCostCredits(), $amount);
            $totalPoints = $this->calculateItemPriceDiscount($catalogItem->getCostPoints(), $amount);
        }

        if($client->getUser()->getData()->getCredits() < $totalCredits || $client->getUser()->getData()->getPixels() < $totalPoints) {
            $client->send(new AlertPurchaseFailedComposer(AlertPurchaseFailedCode::UNKNOWN));
            return;
        }

        $this->finalizePurchase($client, $catalogPage, $catalogItem, $amount, $totalCredits, $totalPoints);
    }

    private function isValidPurchase(IClient $client, int $amount, int $pageId, int $itemId): bool
    {
        if($amount < 1 || $amount > 100) {
            $client->sendMiddleAlert(MiddleAlertKeyTypes::ADMIN_PERSISTENT, 'Invalid amount of items to purchase.');
            return false;
        }

        if($pageId < 0 || $itemId < 0) {
            $client->sendMiddleAlert(MiddleAlertKeyTypes::ADMIN_PERSISTENT, 'Invalid page or item id.');
            return false;
        }

        return true;
    }

    private function handleItemNotFoundPurchase(IClient $client, ?ICatalogPage $catalogPage, int $itemId, int $amount): void
    {
        if($catalogPage->getLayoutHandler() === RecentPurchasesLayout::class) {
            throw new \Exception("Recent purchases not implemented yet.");
        }

        if(in_array($catalogPage->getLayoutHandler(), [SingleBundleLayout::class, RoomBundleLayout::class])) {
            throw new \Exception("Bundle purchases not implemented yet.");
        }
    }

    private function calculateItemPriceDiscount(int $itemPrice, int $amount): int
    {
        $initialDiscount = round($amount / CatalogDiscountData::$discountBatchSize);
        $bonusDiscount = 0;

        if($initialDiscount >= CatalogDiscountData::$minimumDiscountForBonus) {
            if(($amount % CatalogDiscountData::$discountBatchSize) == (CatalogDiscountData::$discountBatchSize - 1)) {
                $bonusDiscount = 1;
            }

            $bonusDiscount += $initialDiscount - CatalogDiscountData::$minimumDiscountForBonus;
        }

        $additionalDiscount = 0;

        foreach (CatalogDiscountData::$additionalDiscountThresholds as $threshold) {
            if($amount >= $threshold) $additionalDiscount++;
        }

        $totalDiscount = ($initialDiscount * CatalogDiscountData::$discountAmountPerBatch) + $bonusDiscount + $additionalDiscount;

        return max(0, round($itemPrice * ($amount - $totalDiscount)));
    }

    private function finalizePurchase(IClient $client, ?ICatalogPage $catalogPage, ?ICatalogItem $catalogItem, int $amount, int $totalCredits, int $totalPoints): void
    {
        $itemDefinition = $catalogItem->getItemsDefinitions()[array_key_first($catalogItem->getItemsDefinitions())];

        if(!($itemDefinition instanceof IItemDefinition)) {
            $client->send(new AlertPurchaseFailedComposer(AlertPurchaseFailedCode::SERVER_ERROR));
            return;
        }

        $catalogPurchaseProvider = CatalogManager::getInstance()->getPurchaseProviderComponent()
            ->getProviderByItemInteraction(/**$itemDefinition->getInteractionType()*/'default');

        if(!($catalogPurchaseProvider instanceof IPurchaseProvider)) {
            $client->send(new AlertPurchaseFailedComposer(AlertPurchaseFailedCode::SERVER_ERROR));
            return;
        }

        $catalogPurchaseProvider->handlePurchase($client, $catalogPage, $catalogItem, $amount, $totalCredits, $totalPoints);
    }
}