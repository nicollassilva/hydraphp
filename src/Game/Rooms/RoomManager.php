<?php

namespace Emulator\Game\Rooms;

use Emulator\Hydra;
use Emulator\Utils\Logger;
use Emulator\Game\Rooms\Room;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Rooms\IRoomManager;
use Emulator\Game\Rooms\Enums\RoomRightLevels;
use Emulator\Game\Rooms\Enums\RoomEntityStatus;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Storage\Repositories\Rooms\RoomRepository;
use Emulator\Networking\Outgoing\Rooms\RoomOpenComposer;
use Emulator\Networking\Outgoing\Rooms\RoomModelComposer;
use Emulator\Networking\Outgoing\Rooms\RoomOwnerComposer;
use Emulator\Networking\Outgoing\Rooms\RoomPaintComposer;
use Emulator\Networking\Outgoing\Rooms\RoomScoreComposer;
use Emulator\Networking\Outgoing\Rooms\RoomRightsComposer;
use Emulator\Networking\Outgoing\Rooms\HideDoorbellComposer;
use Emulator\Networking\Outgoing\Rooms\RoomPromotionComposer;
use Emulator\Networking\Outgoing\Rooms\RoomRightsListComposer;
use Emulator\Game\Rooms\Components\{RoomModelsComponent,ChatBubblesComponent};

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

    public function sendInitialRoomData(IUser $user, int $roomId, string $password, bool $bypassPermissionVerifications = false): void
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

        $user->setEntity(new UserEntity(0, $user, $room));
        $user->getEntity()->clearStatus();

        $user->getClient()->send(new RoomPaintComposer($room));

        $flatCtrl = RoomRightLevels::None;

        if($room->isOwner($user)) {
            $user->getClient()->send(new RoomOwnerComposer);
            $flatCtrl = RoomRightLevels::Moderator;
        }
        
        $user->getEntity()->setStatus(RoomEntityStatus::FlatCtrl, $flatCtrl->value);
        $user->getEntity()->setRoomRightLevel($flatCtrl);
        
        $user->getClient()->send(new RoomRightsComposer($flatCtrl));

        if($flatCtrl->value == RoomRightLevels::Moderator->value) {
            $user->getClient()->send(new RoomRightsListComposer($room));
        }
        
        $user->getClient()
            ->send(new RoomScoreComposer($room))
            ->send(new RoomPromotionComposer);
    }
}