<?php

namespace Emulator\Game\Catalog;

use ArrayObject;
use Emulator\Utils\Logger;
use Emulator\Storage\Repositories\Catalog\CatalogRepository;
use Emulator\Api\Game\Catalog\Data\{ICatalogPage,ICatalogFeaturedPage};
use Emulator\Game\Catalog\Components\{PurchaseProviderComponent, LayoutComponent};

class CatalogManager
{
    public static CatalogManager $instance;

    private readonly Logger $logger;
    private readonly LayoutComponent $layoutComponent;
    private readonly PurchaseProviderComponent $purchaseProviderComponent;

    private bool $isStarted = false;

    /** @var ArrayObject<int,ICatalogPage> $pages */
    private ArrayObject $pages;

    /** @var ArrayObject<int,ICatalogFeaturedPage> $featuredPages */
    private ArrayObject $featuredPages;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));
        
        $this->layoutComponent = new LayoutComponent();
        $this->purchaseProviderComponent = new PurchaseProviderComponent();
        
        $this->pages = new ArrayObject();
        $this->featuredPages = new ArrayObject();
    }

    public static function getInstance(): CatalogManager
    {
        if (!isset(self::$instance)) self::$instance = new CatalogManager();

        return self::$instance;
    }

    public function initialize(): void
    {
        if ($this->isStarted) return;

        CatalogRepository::initialize();

        CatalogRepository::loadPages($this->pages);
        CatalogRepository::loadFeaturedPages($this->featuredPages);

        $totalCatalogItems = CatalogRepository::loadCatalogItems($this->pages);

        $this->isStarted = true;
        
        $this->logger->info(
            sprintf("CatalogManager initialized with %s pages and %s items.", count($this->pages), $totalCatalogItems)
        );
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /** @return ArrayObject<int,ICatalogPage> */
    public function getPages(): ArrayObject
    {
        return $this->pages;
    }

    /** @return ArrayObject<int,ICatalogFeaturedPage> */
    public function getFeaturedPages(): ArrayObject
    {
        return $this->featuredPages;
    }

    public function getPageById(int $id): ?ICatalogPage
    {
        return $this->pages[$id];
    }

    public function getPageByItemId(int $id): ?ICatalogPage
    {
        foreach ($this->pages as $page) {
            if ($page->hasItem($id)) return $page;
        }

        return null;
    }

    /** @return null|ArrayObject<int,ICatalogPage> */
    public function getPagesByParent(int $parentId): ?ArrayObject
    {
        if(!$this->pages->offsetExists($parentId)) return null;

        return $this->pages->offsetGet($parentId)->getChildPages();
    }

    public function getLayoutComponent(): LayoutComponent
    {
        return $this->layoutComponent;
    }

    public function getPurchaseProviderComponent(): PurchaseProviderComponent
    {
        return $this->purchaseProviderComponent;
    }
}
