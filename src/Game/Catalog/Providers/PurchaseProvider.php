<?php

namespace Emulator\Game\Catalog\Providers;

use Emulator\Api\Game\Catalog\Data\{ICatalogPage, ICatalogItem};
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Api\Game\Catalog\Providers\IPurchaseProvider;

class PurchaseProvider implements IPurchaseProvider
{
    public function handlePurchase(IClient $client, ICatalogPage $page, ICatalogItem $item, int $amount, int $totalCredits, int $totalPoints): void
    {
        $client->sendMiddleAlert(
            MiddleAlertKeyTypes::ADMIN_PERSISTENT,
            'You have purchased ' . $amount . ' ' . $item->getCatalogName() . ' for ' . $totalCredits . ' credits and ' . $totalPoints . ' points.'
        );
    }
}