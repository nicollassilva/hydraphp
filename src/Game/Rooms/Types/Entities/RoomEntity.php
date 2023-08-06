<?php

namespace Emulator\Game\Rooms\Types\Entities;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Types\RoomObject;
use Emulator\Game\Rooms\Enums\RoomEntityType;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Api\Game\Rooms\Types\Entities\IRoomEntity;

class RoomEntity extends RoomObject implements IRoomEntity
{
    private RoomEntityType $type;

    private int $bodyRotation;
    private int $headRotation;

    private array $processingPath;
    private array $walkingPath;

    public function __construct(
        int $id,
        IRoom $room,
        Position $startPosition,
        int $bodyRotation,
        int $headRotation
    ) {
        parent::__construct($id, $room, $startPosition);
        
        $this->type = match (true) {
            $this instanceof UserEntity => RoomEntityType::User,
        };

        $this->bodyRotation = $bodyRotation;
        $this->headRotation = $headRotation;
    }

    public function getProcessingPath(): array
    {
        return $this->processingPath;
    }

    public function setProcessingPath(array $processingPath): void
    {
        $this->processingPath = $processingPath;
    }

    public function getWalkingPath(): array
    {
        return $this->walkingPath;
    }

    public function setWalkingPath(array $walkingPath): void
    {
        $this->walkingPath = $walkingPath;
    }

    public function getBodyRotation(): int
    {
        return $this->bodyRotation;
    }

    public function setBodyRotation(int $bodyRotation): void
    {
        $this->bodyRotation = $bodyRotation;
    }

    public function getHeadRotation(): int
    {
        return $this->headRotation;
    }

    public function setHeadRotation(int $headRotation): void
    {
        $this->headRotation = $headRotation;
    }

    public function getType(): RoomEntityType
    {
        return $this->type;
    }

    public function setType(RoomEntityType $type): void
    {
        $this->type = $type;
    }
}