<?php

namespace Emulator\Api\Game\Catalog\Providers;

use Emulator\Api\Game\Catalog\Data\ICatalogItem;
use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Networking\Connections\IClient;

interface IPurchaseProvider
{
    public function handlePurchase(IClient $client, ICatalogPage $page, ICatalogItem $item, int $amount, int $totalCredits, int $totalPoints): void;
}