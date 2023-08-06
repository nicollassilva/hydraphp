<?php

namespace Emulator\Game\Rooms\Types\Entities;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Utilities\Position;
use Emulator\Api\Game\Rooms\Types\Entities\IUserEntity;

class UserEntity extends RoomEntity implements IUserEntity
{
    private readonly IUser $user;
    private readonly Logger $logger;

    private array $status;
    private bool $isKicked;

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

        $this->logger = new Logger(get_class($this));
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
}