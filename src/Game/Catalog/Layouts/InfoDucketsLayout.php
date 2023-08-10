<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

abstract class InfoDucketsLayout implements ICatalogLayout
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage &$page): void
    {
        $message->writeString("info_duckets");
        $message->writeInt(1);
        $message->writeString($page->getPageHeadline());
        $message->writeInt(1);
        $message->writeString($page->getPageText1());
        $message->writeInt(0);
    }
}