<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

abstract class ClubGiftsLayout implements ICatalogLayout
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage $page): void
    {
        $message->writeString("club_gifts");
        $message->writeInt(1);
        $message->writeString($page->getPageHeadline());
        $message->writeInt(1);
        $message->writeString($page->getPageText1());
    }
}