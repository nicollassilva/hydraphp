<?php

namespace Emulator\Game\Rooms\Types\Entities;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Enums\RoomRightLevels;
use Emulator\Api\Game\Rooms\Types\Entities\IUserEntity;
use Emulator\Networking\Outgoing\Rooms\GenericErrorComposer;
use Emulator\Networking\Outgoing\Rooms\HotelViewComposer;
use Emulator\Networking\Outgoing\Rooms\RemoveUserComposer;

/** @property ?IRoom $room */
class UserEntity extends RoomEntity implements IUserEntity
{
    private readonly IUser $user;
    private readonly Logger $logger;

    private bool $isKicked = false;

    private RoomRightLevels $roomRightLevel;

    public function __construct(int $identifier, IUser $user, IRoom $room) {
        parent::__construct($identifier, $room);

        $this->user = $user;
        $this->roomRightLevel = RoomRightLevels::None;

        $this->logger = new Logger($user->getData()->getUsername(), false);
    }

    public function getUser(): IUser
    {
        return $this->user;
    }

    public function isKicked(): bool
    {
        return $this->isKicked;
    }

    public function setIsKicked(bool $isKicked): void
    {
        $this->isKicked = $isKicked;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function setRoom(?IRoom $room): void
    {
        $this->room = $room;
    }

    public function getRoomRightLevel(): RoomRightLevels
    {
        return $this->roomRightLevel;
    }
    
    public function setRoomRightLevel(RoomRightLevels $roomRightLevel): void
    {
        $this->roomRightLevel = $roomRightLevel;
    }

    public function leaveRoom(bool $isOffline, bool $toHotelView)
    {
        if($this->isKicked() && !$isOffline) {
            $this->getUser()->getClient()->send(new GenericErrorComposer(GenericErrorComposer::KICKED_OUT_OF_THE_ROOM));
        }

        $this->getRoom()->broadcastMessage(new RemoveUserComposer($this->getId()));

        if(!$isOffline && $toHotelView) {
            $this->getUser()->getClient()->send(new HotelViewComposer);
        }

        $this->dispose();
    }

    public function dispose(): void
    {
        $this->getRoom()->getEntityComponent()->removeUserEntity($this);
        $this->getUser()->setEntity(null);
        $this->clearStatus();
    }
}