<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Catalog\CatalogManager;
use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;
use Emulator\Api\Game\Catalog\Layouts\{ICatalogLayout, ICatalogFrontPage};
use Emulator\Game\Catalog\Layouts\{FrontPageLayout, RecentPurchasesLayout, FrontPageFeaturedLayout};

class CatalogPageComposer extends MessageComposer
{
    public function __construct(ICatalogPage $page, IUser $user, int $offerId, string $mode)
    {
        $this->header = OutgoingHeaders::$catalogPageComposer;

        $this->writeInt($page->getId());
        $this->writeString($mode);

        /** @var ICatalogLayout|ICatalogFrontPage $layout */
        $layout = CatalogManager::getInstance()->getLayoutComponent()->getByName($page->getPageLayout());

        if (!$layout) return;

        $layout::composeLayout($this, $page);

        if (is_a($layout, RecentPurchasesLayout::class)) {
            $this->writeInt(0); // TODO: Recent purchases
        } else {
            $this->writeInt(count($page->getItems()));

            foreach ($page->getOrderedItems() as $item) {
                $item->compose($this);
            }
        }

        $this->writeInt($offerId);
        $this->writeBoolean(false);

        if (is_a($layout, FrontPageFeaturedLayout::class) || is_a($layout, FrontPageLayout::class)) {
            $this->serializeFrontPageLayout($layout);
        }
    }

    private function serializeFrontPageLayout(ICatalogFrontPage &$layout): void
    {
        $featuredCatalogPages = CatalogManager::getInstance()->getFeaturedPages();

        $this->writeInt(count($featuredCatalogPages));

        foreach ($featuredCatalogPages as $featuredCatalogPage) {
            $layout::composeFrontPage($this, $featuredCatalogPage);
        }
    }
}