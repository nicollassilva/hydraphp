<?php

namespace Emulator\Storage\Repositories\Navigator;

use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Game\Navigator\Data\NavigatorCategory;
use Emulator\Storage\Repositories\EmulatorRepository;
use Emulator\Game\Navigator\Data\NavigatorFilterField;
use Emulator\Api\Game\Navigator\Data\INavigatorCategory;
use Emulator\Game\Navigator\Data\NavigatorPublicCategory;
use Emulator\Game\Navigator\Enums\NavigatorFilterComparator;

abstract class NavigatorRepository extends EmulatorRepository
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

    /** @param array<int,INavigatorCategory> $navigatorCategoriesProperty */
    public static function loadNavigatorCategories(array &$navigatorCategoriesProperty): void
    {
        self::encapsuledSelect('SELECT * FROM navigator_flatcats', function(QueryResult $result) use (&$navigatorCategoriesProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $navigatorCategoriesProperty[$row['id']] = new NavigatorCategory($row);
            }
        });
    }

    /** @param array<int,INavigatorCategory> $publicCategoriesProperty */
    public static function loadNavigatorPublicCategories(array &$publicCategoriesProperty): void
    {
        self::encapsuledSelect("SELECT * FROM navigator_publiccats WHERE visible = '1'", function(QueryResult $result) use (&$publicCategoriesProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $publicCategoriesProperty[$row['id']] = new NavigatorPublicCategory($row);
            }
        });
    }

    /** @param array<int,NavigatorFilterField> $filterSettingsProperty */
    public static function loadNavigatorFilterSettings(array &$filterSettingsProperty): void
    {
        self::encapsuledSelect("SELECT * FROM navigator_filter", function(QueryResult $result) use (&$filterSettingsProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $filterSettingsProperty[$row['key']] = new NavigatorFilterField(
                    $row['key'], $row['field'], NavigatorFilterComparator::from($row['compare']), $row['database_query']
                );
            }
        });
    }
}