<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Game\Catalog\CatalogManager;
use Emulator\Game\Catalog\Layouts\FrontPageFeaturedLayout;
use Emulator\Game\Catalog\Layouts\FrontPageLayout;
use Emulator\Game\Catalog\Layouts\RecentPurchasesLayout;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class CatalogPageComposer extends MessageComposer
{
    public function __construct(ICatalogPage $page, IUser $user, int $offerId, string $mode)
    {
        $this->header = OutgoingHeaders::$catalogPageComposer;

        $this->writeInt($page->getId());
        $this->writeString($mode);

        $layout = CatalogManager::getInstance()->getLayoutComponent()->getByName($page->getPageLayout());

        if(!$layout) return;

        $layout::composeLayout($this, $page);

        if(is_a($layout, RecentPurchasesLayout::class)) {
            $this->writeInt(0); // TODO: Recent purchases
        } else {
            $this->writeInt(0);
        }

        $this->writeInt(0);
        $this->writeInt($offerId);
        $this->writeBoolean(false);

        if(is_a($layout, FrontPageFeaturedLayout::class) || is_a($layout, FrontPageLayout::class)) {
            $this->serializeFrontPageLayout($layout, $page);
        }
    }

    private function serializeFrontPageLayout(string $layout, ICatalogPage $page): void
    {
        $featuredCatalogPages = CatalogManager::getInstance()->getFeaturedPages();

        $this->writeInt(count($featuredCatalogPages));

        foreach($featuredCatalogPages as $featuredCatalogPage) {
            $layout::composeFrontPage($this, $featuredCatalogPage);
        }
    }
}