<?php

namespace Emulator\Storage\Repositories\Navigator;

use ArrayObject;
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

    public static function initialize(): void
    {
        self::$logger = new Logger(static::class);
    }

    public static function getLogger(): Logger
    {
        return self::$logger;
    }

    /** @param ArrayObject<int,INavigatorCategory> $navigatorCategoriesProperty */
    public static function loadNavigatorCategories(ArrayObject &$navigatorCategoriesProperty): void
    {
        self::databaseQuery('SELECT * FROM navigator_flatcats', function(QueryResult $result) use (&$navigatorCategoriesProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $navigatorCategoriesProperty->offsetSet($row['id'], new NavigatorCategory($row));
            }
        });
    }

    /** @param ArrayObject<int,INavigatorCategory> $publicCategoriesProperty */
    public static function loadNavigatorPublicCategories(ArrayObject &$publicCategoriesProperty): void
    {
        self::databaseQuery("SELECT * FROM navigator_publiccats WHERE visible = '1'", function(QueryResult $result) use (&$publicCategoriesProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $publicCategoriesProperty->offsetSet($row['id'], new NavigatorPublicCategory($row));
            }
        });
    }

    /** @param ArrayObject<int,NavigatorFilterField> $filterSettingsProperty */
    public static function loadNavigatorFilterSettings(ArrayObject &$filterSettingsProperty): void
    {
        self::databaseQuery("SELECT * FROM navigator_filter", function(QueryResult $result) use (&$filterSettingsProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $filterSettingsProperty->offsetSet($row['key'], new NavigatorFilterField(
                    $row['key'], $row['field'], NavigatorFilterComparator::from($row['compare']), $row['database_query']
                ));
            }
        });
    }
}