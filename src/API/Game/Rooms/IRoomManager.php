<?php

namespace Emulator\Api\Game\Rooms;

use ArrayObject;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Rooms\Data\IRoomData;
use Emulator\Game\Rooms\Components\{ChatBubblesComponent,RoomModelsComponent};

interface IRoomManager
{
    public function getLogger(): Logger;
    public function initialize(): void;
    public function getLoadedRooms(): ArrayObject;
    public function loadRoom(int $roomId): ?IRoom;
    public function getChatBubblesComponent(): ChatBubblesComponent;
    public function getRoomModelsComponent(): RoomModelsComponent;
    public function sendInitialRoomData(IUser $user, int $roomId, string $password): void;
    public function loadRoomFromData(IRoomData $roomData): ?IRoom;

    /** @return array<int,IRoom> */
    public function getLoadedPublicRooms(): array;

    /** @return array<int,IRoom> */
    public function getPopularRooms(int $roomsLimit): array;

    /** @return array<int,array<IRoom> */
    public function getPopularRoomsByCategory(int $roomsLimit): array;
}