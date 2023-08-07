<?php

namespace Emulator\Game\Rooms\Types\Entities;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Enums\RoomRightLevels;
use Emulator\Game\Rooms\Enums\RoomEntityStatus;
use Emulator\Api\Game\Rooms\Types\Entities\IUserEntity;

class UserEntity extends RoomEntity implements IUserEntity
{
    private readonly IUser $user;
    private readonly Logger $logger;

    private array $status;
    private bool $isKicked;

    private RoomRightLevels $roomRightLevel;

    public function __construct(
        int $identifier,
        IUser $user,
        IRoom $room,
        ?Position $startPosition = null,
        ?int $startBodyRotation = null,
        ?int $startHeadRotation = null
    ) {
        if(!$startPosition) {
            $startPosition = $room->getModel()->getDoorTile()->getPosition();
        }

        if(!$startBodyRotation) {
            $startBodyRotation = $room->getModel()->getDoorDirection();
        }

        if(!$startHeadRotation) {
            $startHeadRotation = $room->getModel()->getDoorDirection();
        }

        parent::__construct($identifier, $room, $startPosition, $startBodyRotation, $startHeadRotation);

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

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function clearStatus(): void
    {
        $this->status = [];
    }

    public function getStatus(): array
    {
        return $this->status;
    }

    public function setStatus(RoomEntityStatus $status, string $key): void
    {
        $this->status[$status->value] = $key;
    }

    public function removeStatus(RoomEntityStatus $status): void
    {
        unset($this->status[$status->value]);
    }

    public function getRoomRightLevel(): RoomRightLevels
    {
        return $this->roomRightLevel;
    }
    
    public function setRoomRightLevel(RoomRightLevels $roomRightLevel): void
    {
        $this->roomRightLevel = $roomRightLevel;
    }
}