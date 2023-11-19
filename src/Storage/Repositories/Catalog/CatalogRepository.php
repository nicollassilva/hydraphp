<?php

namespace Emulator\Storage\Repositories\Catalog;

use ArrayObject;
use Amp\Mysql\MysqlResult;
use Emulator\Utils\Logger;
use Emulator\Storage\Repositories\EmulatorRepository;
use Emulator\Api\Game\Catalog\Data\{ICatalogPage,ICatalogFeaturedPage};
use Emulator\Game\Catalog\Data\{CatalogItem,CatalogPage,CatalogFeaturedPage};

abstract class CatalogRepository extends EmulatorRepository
{
    public static Logger $logger;

    public static function initialize(): void
    {
        self::$logger = new Logger(static::class);
    }

    public static function getLogger(): Logger
    {
        return self::$logger;
    }

    /** @param ArrayObject<int,ICatalogPage> $pagesProperty */
    public static function loadPages(ArrayObject &$pagesProperty): void
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

        $pagesProperty->offsetSet(-1, new CatalogPage($rootPageData));

        self::databaseQuery("SELECT * FROM catalog_pages ORDER BY parent_id, id", function(MysqlResult $result) use (&$pagesProperty) {
            if(empty($result)) return;

            foreach($result as $pageData) {
                $pagesProperty->offsetSet($pageData['id'], new CatalogPage($pageData));
            }
        });

        foreach ($pagesProperty as $page) {
            $parentPage = $pagesProperty[$page->getParentId()] ?? [];

            if(empty($parentPage)) continue;

            $parentPage->addChildPage($page);
        }
    }
    
    /** @param ArrayObject<int,ICatalogFeaturedPage> */
    public static function loadFeaturedPages(ArrayObject &$featuredPagesProperty): void
    {
        self::databaseQuery("SELECT * FROM catalog_featured_pages ORDER BY slot_id ASC", function(MysqlResult $result) use (&$featuredPagesProperty) {
            if(empty($result)) return;

            foreach($result as $pageData) {
                $featuredPagesProperty->offsetSet($pageData['slot_id'], new CatalogFeaturedPage($pageData));
            }
        });
    }

    /** @param ArrayObject<int,ICatalogPage> $catalogPages */
    public static function loadCatalogItems(ArrayObject &$catalogPages): int
    {
        $itemCount = 0;

        self::databaseQuery("SELECT * FROM catalog_items WHERE item_ids <> 0", function(MysqlResult $result) use (&$catalogPages, &$itemCount) {
            if(empty($result)) return;

            foreach($result as $catalogItemData) {
                if(!$catalogPages->offsetExists($catalogItemData['page_id'])) continue;

                $catalogPages->offsetGet($catalogItemData['page_id'])
                    ->addItem(new CatalogItem($catalogItemData));

                $itemCount++;
            }
        });

        return $itemCount;
    }
}