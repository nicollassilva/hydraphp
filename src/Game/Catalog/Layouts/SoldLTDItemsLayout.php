<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

abstract class SoldLTDItemsLayout implements ICatalogLayout
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage &$page): void
    {
        $message->writeString("sold_ltd_items");
        $message->writeInt(3);
        $message->writeString($page->getPageHeadline());
        $message->writeString($page->getPageTeaser());
        $message->writeString($page->getPageSpecial());
        $message->writeInt(0);
    }
}