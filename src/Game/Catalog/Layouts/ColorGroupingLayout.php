<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

abstract class ColorGroupingLayout implements ICatalogLayout
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage &$page): void
    {
        $message->writeString("default_3x3_color_grouping");
        $message->writeInt(3);
        $message->writeString($page->getPageHeadline());
        $message->writeString($page->getPageTeaser());
        $message->writeString($page->getPageSpecial());
        $message->writeInt(3);
        $message->writeString($page->getPageText1());
        $message->writeString($page->getPageTextDetails());
        $message->writeString($page->getPageTextTeaser());
    }
}