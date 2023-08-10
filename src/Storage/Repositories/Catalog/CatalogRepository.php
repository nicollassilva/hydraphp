<?php

namespace Emulator\Storage\Repositories\Catalog;

use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Storage\Repositories\EmulatorRepository;
use Emulator\Api\Game\Catalog\Data\{ICatalogPage,ICatalogFeaturedPage};
use Emulator\Game\Catalog\Data\{CatalogItem,CatalogPage,CatalogFeaturedPage};

abstract class CatalogRepository extends EmulatorRepository
{
    public static Logger $logger;

    public static function initialize()
    {
        self::$logger = new Logger(static::class);
    }

    public static function getLogger(): Logger
    {
        return self::$logger;
    }

    /** @param array<int,ICatalogPage> $pagesProperty */
    public static function loadPages(array &$pagesProperty): void
    {
        $rootPageData = [
            'id' => -1,
            'parent_id' => -2,
            'min_rank' => 1,
            'caption' => 'root',
            'caption_save' => 'root',
            'icon_color' => 0,
            'icon_image' => 0,
            'order_num' => -10,
            'visible' => true,
            'enabled' => true
        ];

        $pagesProperty[-1] = new CatalogPage($rootPageData);

        self::encapsuledSelect("SELECT * FROM catalog_pages ORDER BY parent_id, id", function(QueryResult $result) use (&$pagesProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $pageData) {
                $pagesProperty[$pageData['id']] = new CatalogPage($pageData);
            }
        });

        foreach ($pagesProperty as $page) {
            $parentPage = $pagesProperty[$page->getParentId()] ?? [];

            if(empty($parentPage)) continue;

            $parentPage->addChildPage($page);
        }
    }
    
    /** @param array<int,ICatalogFeaturedPage> */
    public static function loadFeaturedPages(array &$featuredPagesProperty): void
    {
        self::encapsuledSelect("SELECT * FROM catalog_featured_pages ORDER BY slot_id ASC", function(QueryResult $result) use (&$featuredPagesProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $pageData) {
                $featuredPagesProperty[$pageData['slot_id']] = new CatalogFeaturedPage($pageData);
            }
        });
    }

    /** @param array<int,ICatalogPage> $catalogPages */
    public static function loadCatalogItems(array &$catalogPages): int
    {
        $itemCount = 0;

        self::encapsuledSelect("SELECT * FROM catalog_items WHERE item_ids <> 0", function(QueryResult $result) use (&$catalogPages, &$itemCount) {
            if(empty($result->resultRows)) return;

            $itemCount = count($result->resultRows);

            foreach($result->resultRows as $catalogItemData) {
                $catalogPage = &$catalogPages[$catalogItemData['page_id']] ?? null;

                if(empty($catalogPage)) continue;

                $catalogPage->addItem(new CatalogItem($catalogItemData));
            }
        });

        return $itemCount;
    }
}