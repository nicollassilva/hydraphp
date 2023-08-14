<?php

namespace Emulator\Storage\Repositories\Rooms;

use ArrayObject;
use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Api\Game\Rooms\Data\IRoomData;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Game\Rooms\Data\{RoomData,RoomModel};
use Emulator\Storage\Repositories\EmulatorRepository;
use Emulator\Api\Game\Navigator\Data\INavigatorPublicCategory;

abstract class RoomRepository extends EmulatorRepository
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

    public static function loadRoomData(int $roomId): ?IRoomData
    {
        $roomData = null;

        self::encapsuledSelect('SELECT * FROM rooms WHERE id = ?', function(QueryResult $result) use (&$roomData) {
            if(empty($result->resultRows)) return;

            $roomData = new RoomData($result->resultRows[0]);
        }, [$roomId]);

        return $roomData;
    }

    public static function loadRoomModels(): array
    {
        $roomModels = [];

        self::encapsuledSelect('SELECT * FROM room_models', function(QueryResult $result) use (&$roomModels) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $roomModels[$row['name']] = new RoomModel($row);
            }
        });

        return $roomModels;
    }

    /** @param ArrayObject<int,IRoom> */
    public static function loadPublicRooms(ArrayObject &$publicRoomsProperty): void
    {
        self::encapsuledSelect('SELECT * FROM rooms WHERE is_public = ? OR is_staff_picked = ? ORDER BY id DESC', function(QueryResult $result) use (&$publicRoomsProperty) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $room = RoomManager::getInstance()->loadRoomFromData(new RoomData($row));

                if(!$room) continue;

                $publicRoomsProperty->offsetSet($room->getData()->getId(), $room);
            }
        }, ['1', '1']);
    }

    public static function loadStaffPickedRooms(): void
    {
        self::encapsuledSelect("SELECT * FROM navigator_publics JOIN rooms ON rooms.id = navigator_publics.room_id WHERE visible = '1'", function(QueryResult $result) {
            if(empty($result->resultRows)) return;

            foreach($result->resultRows as $row) {
                $category = NavigatorManager::getInstance()->getPublicCategoryById($row['public_cat_id']);

                if(!($category instanceof INavigatorPublicCategory)) {
                    self::getLogger()->error("Navigator public category not found: {$row['public_cat_id']}.");
                    continue;
                }

                $room = RoomManager::getInstance()->loadRoomFromData(new RoomData($row));

                if(!$room) continue;

                $room->getData()->setIsPublic(true);

                $category->addRoom($room);
            }
        });
    }
}