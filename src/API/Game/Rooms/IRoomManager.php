<?php

namespace Emulator\Api\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Components\{ChatBubblesComponent,RoomModelsComponent};

interface IRoomManager
{
    public function getLogger(): Logger;
    public function initialize(): void;
    public function getLoadedRooms(): array;
    public function loadRoom(int $roomId): ?IRoom;
    public function getChatBubblesComponent(): ChatBubblesComponent;
    public function getRoomModelsComponent(): RoomModelsComponent;
    public function sendInitialRoomData(IUser $user, int $roomId, string $password): void;
}