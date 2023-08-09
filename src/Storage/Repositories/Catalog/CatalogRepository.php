<?php

namespace Emulator\Storage\Repositories\Catalog;

use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Game\Catalog\Data\CatalogPage;
use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Storage\Repositories\EmulatorRepository;

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

    /** @return array<int,CatalogPage> */
    public static function loadPages(): array
    {
        $rootPageData = [
            'id' => -1,
            'parent_id' => -2,
            'min_rank' => 0,
            'caption' => 'root',
            'caption_save' => 'root',
            'icon_color' => 0,
            'icon_image' => 0,
            'order_num' => -10,
            'visible' => true,
            'enabled' => true
        ];

        /** @var array<int,ICatalogPage> */
        $pages = [
            -1 => new CatalogPage($rootPageData)
        ];

        self::encapsuledSelect("SELECT * FROM catalog_pages ORDER BY parent_id, id", function(QueryResult $result) use (&$pages) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $pageData) {
                $pages[$pageData['id']] = new CatalogPage($pageData);
            }
        });

        foreach ($pages as $page) {
            $parentPage = $pages[$page->getParentId()] ?? [];

            if(empty($parentPage)) continue;

            $parentPage->addChildPage($page);
        }

        return $pages;
    }
}