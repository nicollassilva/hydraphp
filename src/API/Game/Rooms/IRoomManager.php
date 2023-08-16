<?php

namespace Emulator\Api\Game\Rooms;

use Closure;
use ArrayObject;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Rooms\Data\IRoomData;
use Emulator\Game\Navigator\Data\NavigatorFilterField;
use Emulator\Game\Rooms\Components\{RoomModelsComponent, ChatBubblesComponent};

interface IRoomManager
{
    public function getLogger(): Logger;

    public function initialize(): void;

    public function getLoadedRooms(): ArrayObject;

    public function loadRoom(int $roomId): ?IRoom;

    public function getChatBubblesComponent(): ChatBubblesComponent;

    public function getRoomModelsComponent(): RoomModelsComponent;

    public function loadRoomFromData(?IRoomData $roomData, bool $bypassExists = false, bool $shouldShowLogger = true): ?IRoom;

    /** @return ArrayObject<int,IRoom> */
    public function getLoadedPublicRooms(): ArrayObject;

    /** @param Closure<null|IRoom> $roomNotLoadedCallback */
    public function getLoadedRoomOr(int $id, Closure $callback): ?IRoom;

    /** @return ArrayObject<int,IRoom> */
    public function getPopularRooms(int $roomsLimit): ArrayObject;

    /** @return ArrayObject<int,ArrayObject<IRoom> */
    public function getPopularRoomsByCategory(int $roomsLimit): ArrayObject;

    public function disposeRoom(IRoom &$room): void;

    /** @return ArrayObject<int,IRoom> */
    public function getPromotedRooms(): ArrayObject;

    public function disposeInactiveRooms(): void;
    
    /** @return ArrayObject<int,IRoom> */
    public function findRoomsFromNavigatorSearch(NavigatorFilterField $filterField, string $search, int $roomCategoryId, bool $showInvisible = true): ArrayObject;
}