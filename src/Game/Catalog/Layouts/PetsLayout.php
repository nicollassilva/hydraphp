<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

abstract class PetsLayout implements ICatalogLayout
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage $page): void
    {
        $message->writeString("pets");
        $message->writeInt(2);
        $message->writeString($page->getPageHeadline());
        $message->writeString($page->getPageTeaser());
        $message->writeInt(4);
        $message->writeString($page->getPageText1());
        $message->writeString($page->getPageText2());
        $message->writeString($page->getPageTextDetails());
        $message->writeString($page->getPageTextTeaser());
    }
}