<?php

namespace Emulator\Storage\Repositories\Rooms;

use ArrayObject;
use Emulator\Hydra;
use Amp\Mysql\MysqlResult;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Api\Game\Rooms\Data\IRoomData;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Game\Rooms\Data\{RoomData, RoomModel};
use Emulator\Storage\Repositories\EmulatorRepository;
use Emulator\Game\Navigator\Data\NavigatorFilterField;
use Emulator\Game\Navigator\Enums\NavigatorFilterComparator;
use Emulator\Api\Game\Navigator\Data\INavigatorPublicCategory;

abstract class RoomRepository extends EmulatorRepository
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

    public static function loadRoomData(int $roomId): ?IRoomData
    {
        $roomData = null;

        self::databaseQuery('SELECT * FROM rooms WHERE id = ?', function (MysqlResult $result) use (&$roomData) {
            if (empty($result)) return;

            $roomData = new RoomData($result[0]);
        }, [$roomId]);

        return $roomData;
    }

    public static function loadRoomModels(): array
    {
        $roomModels = [];

        self::databaseQuery('SELECT * FROM room_models', function (MysqlResult $result) use (&$roomModels) {
            if (empty($result)) return;

            foreach ($result as $row) {
                $roomModels[$row['name']] = new RoomModel($row);
            }
        });

        return $roomModels;
    }

    /** @param ArrayObject<int,IRoom> */
    public static function loadPublicRooms(ArrayObject &$publicRoomsProperty): void
    {
        self::databaseQuery('SELECT * FROM rooms WHERE is_public = ? OR is_staff_picked = ? ORDER BY id DESC', function (MysqlResult $result) use (&$publicRoomsProperty) {
            if (empty($result)) return;

            foreach ($result as $row) {
                $room = RoomManager::getInstance()->loadRoomFromData(new RoomData($row), false, false);

                if (!$room) continue;

                $publicRoomsProperty->offsetSet($room->getData()->getId(), $room);
            }
        }, ['1', '1']);
    }

    public static function loadStaffPickedRooms(): void
    {
        self::databaseQuery("SELECT * FROM navigator_publics JOIN rooms ON rooms.id = navigator_publics.room_id WHERE visible = '1'", function (MysqlResult $result) {
            if (empty($result)) return;

            foreach ($result as $row) {
                $category = NavigatorManager::getInstance()->getPublicCategoryById($row['public_cat_id']);

                if (!($category instanceof INavigatorPublicCategory)) {
                    self::getLogger()->error("Navigator public category not found: {$row['public_cat_id']}.");
                    continue;
                }

                $room = RoomManager::getInstance()->loadRoomFromData(new RoomData($row), false, false);

                if (!$room) continue;

                $room->getData()->setIsPublic(true);

                $category->addRoom($room);
            }
        });
    }

    public static function findRoomsFromNavigatorSearch(
        string $databaseQuery,
        string $search,
        ArrayObject &$filteredRooms,
        NavigatorFilterField $filterField
    ): void {
        $preparedValue = $filterField->getComparator() === NavigatorFilterComparator::Contains ? "%{$search}%" : $search;

        self::databaseQuery($databaseQuery, function (MysqlResult $result) use (&$filteredRooms) {
            if (empty($result)) return;

            foreach ($result as $row) {
                $room = RoomManager::getInstance()->getLoadedRoomOr($row['id'], function () use (&$row): ?IRoom {
                    return RoomManager::getInstance()->loadRoomFromData(new RoomData($row));
                });

                if (!$room) {
                    if (Hydra::$isDebugging) self::getLogger()->error("Could not instantiate room: {$row['id']}.");

                    continue;
                }

                if (!$filteredRooms->offsetExists($row['category'])) {
                    $filteredRooms->offsetSet($row['category'], new ArrayObject());
                }

                $filteredRooms->offsetGet($row['category'])
                    ->offsetSet($room->getData()->getId(), $room);
            }
        }, [$preparedValue]);
    }

    public static function createRoomForUser(
        IUser $user,
        string $roomName,
        string $roomDescription,
        string $roomModelName,
        int $roomCategoryId,
        int $maxUsers,
        int $tradeState,
        ?IRoom &$roomInstance
    ): void {
        self::databaseQuery(
            "INSERT INTO rooms (owner_id, owner_name, name, description, model, users_max, category, trade_mode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            function (MysqlResult $queryResult) use (&$roomInstance) {
                if(!$lastInsertId = $queryResult->getLastInsertId()) return;

                $roomInstance = RoomManager::getInstance()->loadRoom($lastInsertId);
            }, [
                $user->getData()->getId(),
                $user->getData()->getUsername(),
                $roomName,
                $roomDescription,
                $roomModelName,
                $maxUsers,
                $roomCategoryId,
                $tradeState
            ]
        );
    }
}
