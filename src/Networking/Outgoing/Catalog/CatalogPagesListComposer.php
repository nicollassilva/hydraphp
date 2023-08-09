<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Catalog\CatalogManager;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class CatalogPagesListComposer extends MessageComposer
{
    public function __construct(IUser $user, string $mode)
    {
        $this->header = OutgoingHeaders::$catalogPagesListComposer;

        $pages = CatalogManager::getInstance()->getPagesByParent(-1);

        $this->writeBoolean(true);
        $this->writeInt(0);
        $this->writeInt(-1);
        $this->writeString("root");
        $this->writeString("");
        $this->writeInt(0);
        $this->writeInt(count($pages));

        foreach($pages as $page) {
            $this->writeCatalogPage($page);
        }

        $this->writeBoolean(false);
        $this->writeString($mode);
    }

    private function writeCatalogPage(ICatalogPage $page): void
    {
        /** @var array<int,ICatalogPage> */
        $childPages = $page->getChildPages();

        $this->writeBoolean($page->isVisible());
        $this->writeInt($page->getIconImage());
        $this->writeInt($page->isEnabled() ? $page->getId() : -1);
        $this->writeString($page->getCaptionSave());
        $this->writeString(sprintf("%s (%s)", $page->getCaption(), $page->getId()));
        $this->writeInt(0);
        $this->writeInt(count($childPages));

        foreach ($childPages as $childPage) {
            $this->writeCatalogPage($childPage);
        }
    }
}