<?php

namespace Emulator\Storage\Repositories\Items;

use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Storage\Repositories\EmulatorRepository;
use Emulator\Api\Game\Items\Data\IItemDefinition;
use Emulator\Game\Items\Data\ItemDefinition;

abstract class ItemRepository extends EmulatorRepository
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

    /** @param array<int,IItemDefinition> $itemsDefinitionsProperty */
    public static function loadItemDefinitions(array &$itemsDefinitionsProperty): void
    {
        self::encapsuledSelect('SELECT * FROM items_base ORDER BY id DESC', function(QueryResult $result) use (&$itemsDefinitionsProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $itemsDefinitionsProperty[$row['id']] = new ItemDefinition($row);
            }
        });
    }
}