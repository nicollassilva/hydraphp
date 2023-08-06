<?php

namespace Emulator\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Game\Rooms\Room;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Rooms\IRoomManager;
use Emulator\Game\Rooms\Component\ChatBubblesComponent;
use Emulator\Storage\Repositories\Rooms\RoomRepository;

class RoomManager implements IRoomManager
{
    public static IRoomManager $instance;

    private readonly Logger $logger;

    private bool $isStarted = false;

    private array $loadedRooms = [];

    private readonly ChatBubblesComponent $chatBubblesComponent;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));

        $this->chatBubblesComponent = new ChatBubblesComponent();
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

    public function getChatBubblesComponent(): ChatBubblesComponent
    {
        return $this->chatBubblesComponent;
    }

    public function initialize(): void
    {
        if($this->isStarted) return;

        $this->isStarted = true;

        RoomRepository::initialize();

        $this->logger->info('Room manager initialized.');
    }

    public function loadRoom(int $roomId): ?IRoom
    {
        if(isset($this->loadedRooms[$roomId])) return $this->loadedRooms[$roomId];

        $roomData = RoomRepository::loadRoomData($roomId);

        if($roomData === null) return null;

        $room = new Room($roomData);

        $this->loadedRooms[$roomId] = &$room;

        return $room;
    }

    public function getLoadedRooms(): array
    {
        return $this->loadedRooms;
    }
}