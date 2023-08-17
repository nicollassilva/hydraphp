<?php

namespace Emulator\Storage\Repositories\Items;

use Throwable;
use ArrayObject;
use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Items\ItemFactory;
use Emulator\Game\Items\ItemManager;
use Emulator\Game\Items\Data\ItemDefinition;
use Emulator\Api\Game\Items\Data\IItemDefinition;
use Emulator\Game\Items\Enums\ItemDefinitionType;
use Emulator\Storage\Repositories\EmulatorRepository;

abstract class ItemRepository extends EmulatorRepository
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

    /** 
     * @param ArrayObject<int,IRoomItem> $floorItemsProperty
     * @param ArrayObject<int,IRoomItem> $wallItemsProperty
     */
    public static function loadRoomItemsByRoomId(IRoom &$room, ArrayObject &$floorItemsProperty, ArrayObject &$wallItemsProperty): void
    {
        self::encapsuledSelect('SELECT items.*, items_base.interaction_type,
            items_base.type, users.username AS owner_name FROM items
            JOIN items_base ON items.item_id = items_base.id 
            JOIN users ON users.id = items.user_id
            WHERE room_id = ?', function(QueryResult $result) use (&$floorItemsProperty, &$wallItemsProperty, &$room) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                try {
                    $definitionType = ItemDefinitionType::from($row['type']) ?? null;

                    if(!$definitionType) continue;

                    $itemInstance = ItemFactory::getInstance()->createItemFromQueryResult($row, $room, $definitionType);

                    if($definitionType === ItemDefinitionType::Floor) {
                        $floorItemsProperty->offsetSet($itemInstance->getData()->getId(), $itemInstance);
                        continue;
                    }

                    if($definitionType === ItemDefinitionType::Wall) {
                        $wallItemsProperty->offsetSet($itemInstance->getData()->getId(), $itemInstance);
                        continue;
                    }
                } catch (Throwable $error) {
                    ItemManager::getInstance()->getLogger()
                        ->error("Failed to instantiate a room item with ID #{$row['id']} in room {$room->getData()->getId()}. Error: {$error->getMessage()}");
                }
            }
        }, [$room->getData()->getId()]);
    }
}