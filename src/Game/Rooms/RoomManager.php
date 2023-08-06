<?php

namespace Emulator\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Game\Rooms\Room;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Rooms\IRoomManager;
use Emulator\Api\Game\Users\IUser;
use Emulator\Storage\Repositories\Rooms\RoomRepository;
use Emulator\Game\Rooms\Components\{RoomModelsComponent,ChatBubblesComponent};
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Hydra;
use Emulator\Networking\Outgoing\Rooms\HideDoorbellComposer;

class RoomManager implements IRoomManager
{
    public static IRoomManager $instance;

    private readonly Logger $logger;

    private bool $isStarted = false;

    // @param array<int, IRoom>
    private array $loadedRooms = [];

    private readonly ChatBubblesComponent $chatBubblesComponent;
    private readonly RoomModelsComponent $roomModelsComponent;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));

        $this->chatBubblesComponent = new ChatBubblesComponent();
        $this->roomModelsComponent = new RoomModelsComponent();
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

    public function getRoomModelsComponent(): RoomModelsComponent
    {
        return $this->roomModelsComponent;
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
        if(isset($this->loadedRooms[$roomId])) {
            $this->getLogger()->info("Room already loaded: {$roomId}.");
            return $this->loadedRooms[$roomId];
        }

        $roomData = RoomRepository::loadRoomData($roomId);

        if($roomData === null) return null;

        $room = new Room($roomData);

        $this->loadedRooms[$roomId] = &$room;

        $this->getLogger()->info("Room loaded successfully: {$roomId}.");

        return $room;
    }

    public function getLoadedRooms(): array
    {
        return $this->loadedRooms;
    }

    public function enterRoom(IUser $user, int $roomId, string $password, bool $bypassPermissionVerifications = false): void
    {
        $room = $this->loadRoom($roomId);

        if(empty($room)) {
            if(Hydra::$isDebugging) {
                $this->getLogger()->warning("Room not found: {$roomId}.");
            }

            return;
        }

        if(empty($room->getModel())) {
            if(Hydra::$isDebugging) {
                $this->getLogger()->warning("Room model not found: {$roomId}.");
            }

            return;
        }

        $user->getClient()->send(new HideDoorbellComposer(""));

        $user->setEntity(new UserEntity(random_int(0, 10000), $user, $room));
        $user->getEntity()->clearStatus();
    }
}