<?php

namespace Emulator\Game\Catalog;

use Emulator\Utils\Logger;
use Emulator\Game\Catalog\Components\LayoutComponent;
use Emulator\Storage\Repositories\Catalog\CatalogRepository;
use Emulator\Api\Game\Catalog\Data\{ICatalogPage,ICatalogFeaturedPage};

class CatalogManager
{
    public static CatalogManager $instance;

    private readonly Logger $logger;
    private readonly LayoutComponent $layoutComponent;

    private bool $isStarted = false;

    /** @var array<int,ICatalogPage> */
    private array $pages = [];

    /** @var array<int,ICatalogFeaturedPage> */
    private array $featuredPages = [];

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));

        $this->layoutComponent = new LayoutComponent();
    }

    public static function getInstance()
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

    /** @return array<int,ICatalogPage> */
    public function getPages(): array
    {
        return $this->pages;
    }

    /** @return array<int,ICatalogFeaturedPage> */
    public function getFeaturedPages(): array
    {
        return $this->featuredPages;
    }

    public function getPageById(int $id): ?ICatalogPage
    {
        return $this->pages[$id];
    }

    /** @return array<int,ICatalogPage> */
    public function getPagesByParent(int $parentId): array
    {
        return $this->pages[$parentId]?->getChildPages() ?? null;
    }

    public function getLayoutComponent(): LayoutComponent
    {
        return $this->layoutComponent;
    }
}
