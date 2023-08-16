<?php

namespace Emulator\Game\Catalog\Data;

use Emulator\Game\Items\ItemManager;
use Emulator\Game\Items\Data\ItemDefinition;
use Emulator\Api\Game\Catalog\Data\ICatalogItem;
use Emulator\Api\Game\Items\Data\IItemDefinition;
use Emulator\Game\Items\Enums\ItemDefinitionType;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

class CatalogItem implements ICatalogItem
{
    private readonly int $id;

    /** @var array<string> */
    private readonly array $itemIds;
    private readonly int $pageId;
    private readonly string $catalogName;
    private readonly int $costCredits;
    private readonly int $costPoints;
    private readonly int $pointsType;
    private readonly int $amount;
    private readonly int $limitedStack;
    private readonly int $limitedSells;
    private readonly int $orderNumber;
    private readonly int $offerId;
    private readonly int $songId;
    private readonly string $extraData;
    private readonly bool $haveOffer;
    private readonly bool $isClubOnly;

    /** @var array<int,IItemDefinition> */
    private array $itemsDefinitions = [];

    public function __construct(array &$data)
    {
        $this->id = (int) $data['id'];
        $this->itemIds = explode(';', $data['item_ids']);
        $this->pageId = (int) $data['page_id'];
        $this->catalogName = $data['catalog_name'];
        $this->costCredits = (int) $data['cost_credits'];
        $this->costPoints = (int) $data['cost_points'];
        $this->pointsType = (int) $data['points_type'];
        $this->amount = (int) $data['amount'];
        $this->limitedStack = (int) $data['limited_stack'];
        $this->limitedSells = (int) $data['limited_sells'];
        $this->orderNumber = (int) $data['order_number'];
        $this->offerId = (int) $data['offer_id'];
        $this->songId = (int) $data['song_id'];
        $this->extraData = $data['extradata'];
        $this->haveOffer = (bool) $data['have_offer'];
        $this->isClubOnly = (bool) $data['club_only'];

        $this->attachItemsInstance();
    }

    private function attachItemsInstance(): void
    {
        foreach ($this->getItemIds() as $itemId) {
            $this->itemsDefinitions[$itemId] = ItemManager::getInstance()->getItemById($itemId);
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    /** @return array<string> */
    public function getItemIds(): array
    {
        return $this->itemIds;
    }

    public function getPageId(): int
    {
        return $this->pageId;
    }

    public function getCatalogName(): string
    {
        return $this->catalogName;
    }

    public function getCostCredits(): int
    {
        return $this->costCredits;
    }

    public function getCostPoints(): int
    {
        return $this->costPoints;
    }

    public function getPointsType(): int
    {
        return $this->pointsType;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getLimitedStack(): int
    {
        return $this->limitedStack;
    }

    public function getLimitedSells(): int
    {
        return $this->limitedSells;
    }

    public function getOrderNumber(): int
    {
        return $this->orderNumber;
    }

    public function getOfferId(): int
    {
        return $this->offerId;
    }

    public function getSongId(): int
    {
        return $this->songId;
    }

    public function getExtraData(): string
    {
        return $this->extraData;
    }

    public function haveOffer(): bool
    {
        return $this->haveOffer;
    }

    public function checkHaveOffer(): bool
    {
        if($this->haveOffer()) {
            return false;
        }

        if($this->getAmount() != 1) {
            return false;
        }

        if($this->isLimited()) {
            return false;
        }

        // check bundle here

        if(str_starts_with($this->getCatalogName(), 'cf_') || str_starts_with($this->getCatalogName(), 'cfc_')) {
            return false;
        }

        foreach($this->getItemsDefinitions() as $item) {
            if(str_starts_with($item->getItemName(), 'cf_') || str_starts_with($item->getItemName(), 'cfc_') || str_starts_with($item->getItemName(), 'rentable_bot')) {
                return false;
            }
        }

        return !str_starts_with($this->getCatalogName(), 'rentable_bot_');
    }

    public function isClubOnly(): bool
    {
        return $this->isClubOnly;
    }

    /** @return array<int,IItemDefinition> */
    public function getItemsDefinitions(): array
    {
        return $this->itemsDefinitions;
    }

    public function isLimited(): bool
    {
        return $this->limitedStack > 0;
    }

    public function compose(IMessageComposer $message): void
    {
        $message->writeInt($this->getId());
        $message->writeString($this->getCatalogName());
        $message->writeBoolean(false);
        $message->writeInt($this->getCostCredits());
        $message->writeInt($this->getCostPoints());
        $message->writeInt($this->getPointsType());
        $message->writeBoolean(false); // allow gift

        $items = $this->getItemsDefinitions();

        $message->writeInt(count($items));

        foreach ($items as $item) {
            if(!($item instanceof ItemDefinition)) continue;
            
            $message->writeString(strtolower($item->getType()->value));

            if($item->getType() === ItemDefinitionType::Badge) {
                $message->writeString($item->getItemName());
                continue;
            }

            $message->writeInt($item->getSpriteId());

            if($item->isDecorationItem()) {
                $message->writeString(explode('_', $item->getItemName())[2]);
            } else if($item->getType() === ItemDefinitionType::Robot && str_contains($item->getItemName(), 'bot')) {
                $botFigure = '';

                foreach(explode(';', $this->getExtraData()) as $catalogItemData) {
                    if(str_starts_with(strtolower($catalogItemData), 'figure:')) {
                        $botFigure = str_ireplace('figure:', '', $catalogItemData);                        
                    }
                }

                $message->writeString(strlen($botFigure) ? $botFigure : $this->getExtraData());
                unset($botFigure);
            } else if($item->getType() === ItemDefinitionType::Robot || strcasecmp($item->getItemName(), 'poster') === 0 || str_starts_with($item->getItemName(), 'SONG ')) {
                $message->writeString($this->getExtraData());
            } else {
                $message->writeString('');
            }

            $message->writeInt($this->getAmount());
            $message->writeBoolean($this->isLimited());

            if($this->isLimited()) {
                $message->writeInt($this->getLimitedStack());
                $message->writeInt($this->getLimitedStack() - $this->getLimitedStack());
            }
        }

        $message->writeInt($this->isClubOnly() ? 1 : 0);
        $message->writeBoolean($this->checkHaveOffer());
        $message->writeBoolean(false);
        $message->writeString("{$this->getCatalogName()}.png");
    }
}