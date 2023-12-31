<?php

namespace Emulator\Game\Rooms;

use Closure;
use ArrayObject;
use Emulator\Hydra;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\Data\IRoomData;
use Emulator\Game\Rooms\Enums\LoadedRoomSort;
use Emulator\Api\Game\Rooms\{IRoom, IRoomManager};
use Emulator\Game\Navigator\Data\NavigatorFilterField;
use Emulator\Storage\Repositories\Rooms\RoomRepository;
use Emulator\Game\Rooms\Components\{RoomModelsComponent, ChatBubblesComponent};

class RoomManager implements IRoomManager
{
    public static IRoomManager $instance;

    private readonly Logger $logger;

    /** @var ArrayObject<int,IRoom> */
    private ArrayObject $loadedRooms;

    /** @var ArrayObject<int,IRoom> */
    private ArrayObject $publicRooms;

    private readonly ChatBubblesComponent $chatBubblesComponent;
    private readonly RoomModelsComponent $roomModelsComponent;

    private bool $isStarted = false;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));

        $this->chatBubblesComponent = new ChatBubblesComponent();
        $this->roomModelsComponent = new RoomModelsComponent();

        $this->loadedRooms = new ArrayObject();
        $this->publicRooms = new ArrayObject();
    }

    public static function getInstance(): IRoomManager
    {
        if (!isset(self::$instance)) self::$instance = new RoomManager();

        return self::$instance;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function initialize(): void
    {
        if ($this->isStarted) return;

        $this->isStarted = true;

        RoomRepository::initialize();
        RoomRepository::loadPublicRooms($this->publicRooms);
        RoomRepository::loadStaffPickedRooms();

        $this->logger->info('RoomManager initialized.');
    }

    public function getChatBubblesComponent(): ChatBubblesComponent
    {
        return $this->chatBubblesComponent;
    }

    public function getRoomModelsComponent(): RoomModelsComponent
    {
        return $this->roomModelsComponent;
    }

    public function loadRoom(int $roomId): ?IRoom
    {
        if ($this->loadedRooms->offsetExists($roomId)) {
            if (Hydra::$isDebugging) $this->getLogger()->info("Room already loaded: {$roomId}.");

            return $this->loadedRooms->offsetGet($roomId);
        }

        return $this->loadRoomFromData(
            RoomRepository::loadRoomData($roomId),
            true
        );
    }

    public function loadRoomFromData(?IRoomData $roomData, bool $bypassExists = false, bool $shouldShowLogger = true): ?IRoom
    {
        if ($roomData === null) return null;

        if (!$bypassExists && $this->loadedRooms->offsetExists($roomData->getId())) {
            if (Hydra::$isDebugging && $shouldShowLogger) $this->getLogger()->info("Room already loaded: {$roomData->getId()}.");

            return $this->loadedRooms->offsetGet($roomData->getId());
        }

        $room = new Room($roomData);

        $this->loadedRooms->offsetSet($roomData->getId(), $room);

        if (Hydra::$isDebugging && $shouldShowLogger) $this->getLogger()->info("Room loaded successfully: {$roomData->getName()}.");

        return $room;
    }

    public function getLoadedRooms(): ArrayObject
    {
        return $this->loadedRooms;
    }

    /** @param Closure<null|IRoom> $roomNotLoadedCallback */
    public function getLoadedRoomOr(int $id, Closure $roomNotLoadedCallback): ?IRoom
    {
        if(!$this->loadedRooms->offsetExists($id)) {
            return $roomNotLoadedCallback();
        }

        return $this->loadedRooms->offsetGet($id);
    }

    /** @return ArrayObject<int,IRoom> */
    public function getLoadedPublicRooms(): ArrayObject
    {
        $publicRooms = $this->publicRooms;

        $publicRooms->uasort(
            fn(IRoom $a, IRoom $b) => $a->getData()->getId() <=> $b->getData()->getId()
        );

        return $publicRooms;
    }

    /** @return ArrayObject<int,IRoom> */
    public function getPopularRooms(int $roomsLimit): ArrayObject
    {
        $rooms = new ArrayObject;

        foreach ($this->loadedRooms as $room) {
            if ($rooms->count() >= $roomsLimit) break;

            if ($room->getEntityComponent()->getUserEntitiesCount() > 0) {
                $rooms->append($room);
            }
        }

        return $rooms;
    }

    /** @return ArrayObject<int,ArrayObject<IRoom> */
    public function getPopularRoomsByCategory(int $roomsLimit): ArrayObject
    {
        $popularRooms = new ArrayObject;
        $sortedRooms = $this->getSortedLoadedRooms(LoadedRoomSort::UsersCount);

        foreach ($sortedRooms as $room) {
            if (!$popularRooms->offsetExists($room->getData()->getCategoryId())) {
                $popularRooms->offsetSet($room->getData()->getCategoryId(), new ArrayObject);
            }

            if ($popularRooms->offsetGet($room->getData()->getCategoryId())->count() >= $roomsLimit) break;

            if ($room->getEntityComponent()->getUserEntitiesCount() <= 0 && !$room->getProcessComponent()->started()) continue;

            $popularRooms->offsetGet($room->getData()->getCategoryId())->append($room);
        }

        return $popularRooms;
    }

    public function disposeRoom(IRoom &$room): void
    {
        if ($room->getData()->isPublic()) return;

        if (Hydra::$isDebugging) $this->getLogger()->advertisement("Room [{$room->getData()->getName()} #{$room->getData()->getId()}] completely disposed successfully.");

        $this->loadedRooms->offsetUnset($room->getData()->getId());

        if ($this->publicRooms->offsetExists($room->getData()->getId())) {
            $this->publicRooms->offsetUnset($room->getData()->getId());
        }

        $room->dispose(true);
        $room = null;
    }

    /** @return ArrayObject<int,IRoom> */
    private function getSortedLoadedRooms(LoadedRoomSort $sortBy): ArrayObject
    {
        $sortedLoadedRooms = $this->loadedRooms;

        if ($sortBy === LoadedRoomSort::UsersCount) {
            $sortedLoadedRooms->uasort(
                fn(IRoom $roomA, IRoom $roomB) => $roomA->getEntityComponent()->getUserEntitiesCount() < $roomB->getEntityComponent()->getUserEntitiesCount() ? -1 : 1
            );
        }

        if ($sortBy == LoadedRoomSort::Id) {
            $sortedLoadedRooms->uasort(
                fn(IRoom $roomA, IRoom $roomB) => $roomA->getData()->getId() < $roomB->getData()->getId() ? -1 : 1
            );
        }

        return $sortedLoadedRooms;
    }

    /** @return ArrayObject<int,IRoom> */
    public function getPromotedRooms(): ArrayObject
    {
        $rooms = new ArrayObject();

        foreach ($this->loadedRooms as $room) {
            if ($room->getData()->isPromoted()) {
                $rooms->append($room);
            }
        }

        return $rooms;
    }

    /** @return ArrayObject<int,IRoom> */
    public function findRoomsFromNavigatorSearch(NavigatorFilterField $filterField, string $search, int $roomCategoryId, bool $showInvisible = true): ArrayObject
    {
        $rooms = new ArrayObject;

        $databaseQuery = sprintf("%s AND rooms.state NOT LIKE '%s' %s ORDER BY rooms.users, rooms.id DESC LIMIT 10",
            $filterField->getQuery(),
            $showInvisible ? '' : 'invisible',
            $roomCategoryId >= 0 ? "AND rooms.category = '{$roomCategoryId}'": ''
        );

        RoomRepository::findRoomsFromNavigatorSearch($databaseQuery, $search, $rooms, $filterField);

        return $rooms;
    }

    public function disposeInactiveRooms(): void
    {
        foreach ($this->loadedRooms as $room) {
            if (!$room->canBeCompletelyDisposed()) continue;

            $this->disposeRoom($room);
        }
    }
}
