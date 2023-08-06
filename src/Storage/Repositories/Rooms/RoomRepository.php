<?php

namespace Emulator\Storage\Repositories\Rooms;

use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Game\Rooms\Data\RoomData;
use Emulator\Game\Rooms\Data\RoomModel;
use Emulator\Api\Game\Rooms\Data\IRoomData;
use Emulator\Storage\Repositories\EmulatorRepository;

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
}