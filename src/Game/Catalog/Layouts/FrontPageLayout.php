<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Catalog\Data\ICatalogFeaturedPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogFrontPage;

abstract class FrontPageLayout implements ICatalogFrontPage
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage &$page): void
    {
        $message->writeString("frontpage4");
        $message->writeInt(2);
        $message->writeString($page->getPageHeadline());
        $message->writeString($page->getPageTeaser());
        $message->writeInt(3);
        $message->writeString($page->getPageText1());
        $message->writeString($page->getPageText2());
        $message->writeString($page->getPageTextTeaser());
    }

    public static function composeFrontPage(IMessageComposer $message, ICatalogFeaturedPage &$page): void
    {
        $page->compose($message);
    }
}