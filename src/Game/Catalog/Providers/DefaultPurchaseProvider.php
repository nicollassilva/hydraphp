<?php

namespace Emulator\Game\Catalog\Providers;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Api\Game\Catalog\Data\{ICatalogPage, ICatalogItem};

class DefaultPurchaseProvider extends PurchaseProvider
{
    public function handlePurchase(IClient $client, ICatalogPage $page, ICatalogItem $item, int $amount, int $totalCredits, int $totalPoints): void
    {
        parent::handlePurchase($client, $page, $item, $amount, $totalCredits, $totalPoints);
    }
}