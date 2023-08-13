<?php

namespace Emulator\Game\Rooms;

use ArrayObject;
use Emulator\Hydra;
use Emulator\Utils\Logger;
use Emulator\Game\Rooms\Room;
use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Rooms\Data\IRoomData;
use Emulator\Api\Game\Rooms\{IRoomManager,IRoom};
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Storage\Repositories\Rooms\RoomRepository;
use Emulator\Game\Rooms\Enums\{RoomEntityStatus,RoomRightLevels};
use Emulator\Game\Rooms\Components\{RoomModelsComponent,ChatBubblesComponent};
use Emulator\Networking\Outgoing\Rooms\{RoomRightsComposer,RoomScoreComposer,RoomPaintComposer,RoomOwnerComposer,RoomRightsListComposer,RoomPromotionComposer,HideDoorbellComposer};

class RoomManager implements IRoomManager
{
    public CONST IDLE_CYCLES_BEFORE_DISPOSE = 60;
    public CONST ROOM_TICK_MS = 0.5;

    public static IRoomManager $instance;

    private readonly Logger $logger;

    private bool $isStarted = false;

    /** @var ArrayObject<int,IRoom> */
    private ArrayObject $loadedRooms;
    
    /** @var ArrayObject<int,IRoom> */
    private ArrayObject $publicRooms;

    private readonly ChatBubblesComponent $chatBubblesComponent;
    private readonly RoomModelsComponent $roomModelsComponent;

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
        if(!isset(self::$instance)) self::$instance = new RoomManager();

        return self::$instance;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function initialize(): void
    {
        if($this->isStarted) return;

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
        if($this->loadedRooms->offsetExists($roomId)) {
            if(Hydra::$isDebugging) $this->getLogger()->info("Room already loaded: {$roomId}.");

            return $this->loadedRooms->offsetGet($roomId);
        }

        $roomData = RoomRepository::loadRoomData($roomId);

        if($roomData === null) return null;

        $room = new Room($roomData);

        $this->loadedRooms[$roomId] = &$room;


        return $room;
    }

    public function loadRoomFromData(IRoomData $roomData): ?IRoom
    {
        if($roomData === null) return null;

        if($this->loadedRooms->offsetExists($roomData->getId())) {
            if(Hydra::$isDebugging) $this->getLogger()->info("Room already loaded: {$roomData->getId()}.");

            return $this->loadedRooms->offsetGet($roomData->getId());
        }

        $room = new Room($roomData);

        $this->loadedRooms->offsetSet($roomData->getId(), $room);

        if(Hydra::$isDebugging) $this->getLogger()->info("Room loaded successfully: {$roomData->getName()}.");

        return $room;
    }

    public function getLoadedRooms(): ArrayObject
    {
        return $this->loadedRooms;
    }

    /** @return array<int,IRoom> */
    public function getLoadedPublicRooms(): array
    {
        $publicRooms = $this->publicRooms->getArrayCopy();

        usort($publicRooms,
            fn(IRoom $a, IRoom $b) => $a->getData()->getId() <=> $b->getData()->getId()
        );

        return $publicRooms;
    }
    
    /** @return array<int,IRoom> */
    public function getPopularRooms(int $roomsLimit): array
    {
        $rooms = [];

        foreach($this->loadedRooms as $room) {
            if($room->getEntityComponent()->getUserEntitiesCount() > 0) {
                $rooms[] = $room;
            }
        }

        usort($rooms, 
            fn (IRoom $a, IRoom $b) => $a->getEntityComponent()->getUserEntitiesCount() < $b->getEntityComponent()->getUserEntitiesCount()
        );

        return array_slice($rooms, 0, $roomsLimit);
    }
    
    /** @return array<int,array<IRoom> */
    public function getPopularRoomsByCategory(int $roomsLimit): array
    {
        $rooms = [];

        foreach($this->loadedRooms as $room) {
            if($room->getData()->isPublic()) continue;

            if(!array_key_exists($room->getData()->getCategoryId(), $rooms)) {
                $rooms[$room->getData()->getCategoryId()] = [];
            }
            
            $rooms[$room->getData()->getCategoryId()][] = $room;
        }

        usort($rooms, 
            fn (IRoom $roomA, IRoom $roomB) => $roomA->getEntityComponent()->getUserEntitiesCount() < $roomB->getEntityComponent()->getUserEntitiesCount()
        );

        return array_slice($rooms, 0, $roomsLimit);
    }

    public function disposeRoom(IRoom &$room): void
    {
        if($room === null || $room->getData()->isPublic()) return;

        if(Hydra::$isDebugging) $this->getLogger()->info("Room [{$room->getData()->getName()} #{$room->getData()->getId()}] disposed successfully.");

        $this->loadedRooms->offsetUnset($room->getData()->getId());

        if($this->publicRooms->offsetExists($room->getData()->getId())) {
            $this->publicRooms->offsetUnset($room->getData()->getId());
        }

        $room = null;
    }
}