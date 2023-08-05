<?php

namespace Emulator\Api\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;

interface IRoomManager
{
    public function getLogger(): Logger;
    public function initialize(): void;
    public function getLoadedRooms(): array;
    public function loadRoom(int $roomId): ?IRoom;
}