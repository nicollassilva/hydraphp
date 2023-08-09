<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

abstract class MarketplaceLayout implements ICatalogLayout
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage $page): void
    {
        $message->writeString("marketplace");
        $message->writeInt(0);
        $message->writeInt(0);
    }
}