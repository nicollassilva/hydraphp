<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Catalog\Data\ICatalogFeaturedPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogFrontPage;

abstract class FrontPageFeaturedLayout implements ICatalogLayout, ICatalogFrontPage
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage $page): void
    {
        $message->writeString("frontpage_featured");

        $teaserImages = explode(';', $page->getPageTeaser());
        $specialImages = explode(';', $page->getPageSpecial());

        $message->writeInt(1 + count($teaserImages) + count($specialImages));
        $message->writeString($page->getPageHeadline());

        foreach ($teaserImages as $image) {
            $message->writeString($image);
        }

        foreach ($specialImages as $image) {
            $message->writeString($image);
        }

        $message->writeInt(3);
        $message->writeString($page->getPageText1());
        $message->writeString($page->getPageTextDetails());
        $message->writeString($page->getPageTextTeaser());
    }

    public static function composeFrontPage(IMessageComposer $message, ICatalogFeaturedPage $page): void
    {
        $page->compose($message);
    }
}