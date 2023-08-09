<?php

namespace Emulator\Game\Catalog;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Storage\Repositories\Catalog\CatalogRepository;

class CatalogManager
{
    private readonly Logger $logger;

    public static CatalogManager $instance;

    /** @var array<int,ICatalogPage> */
    private array $pages = [];

    private bool $isStarted = false;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));
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

        $this->loadPages();

        $this->isStarted = true;
        $this->logger->info("CatalogManager initialized.");
    }

    private function loadPages(): void
    {
        $this->pages = CatalogRepository::loadPages();
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /** @return array<int, ICatalogPage> */
    public function getPages(): array
    {
        return $this->pages;
    }

    /** @return array<int,ICatalogPage> */
    public function getPagesByParent(int $parentId): array
    {
        return $this->pages[$parentId]?->getChildPages() ?? null;
    }
}
