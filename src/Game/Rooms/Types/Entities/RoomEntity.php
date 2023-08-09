<?php

namespace Emulator\Game\Rooms\Types\Entities;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Data\RoomTile;
use Emulator\Game\Rooms\Types\RoomObject;
use Emulator\Api\Game\Utilities\IMoveable;
use Emulator\Game\Rooms\Enums\RoomTileState;
use Emulator\Game\Rooms\Enums\RoomEntityType;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Game\Rooms\Utils\Pathfinder\Pathfinder;
use Emulator\Api\Game\Rooms\Types\Entities\IRoomEntity;

class RoomEntity extends RoomObject implements IRoomEntity, IMoveable
{
    private RoomEntityType $type;

    private int $bodyRotation;
    private int $headRotation;

    /** @var RoomTile[] */
    private array $processingPath = [];
    
    /** @var RoomTile[] */
    private array $walkingPath = [];

    private int $previousSteps = 0;

    private bool $needsUpdate = false;

    private ?RoomTile $nextTile = null;

    public function __construct(int $id, IRoom $room) {
        $doorTile = $room->getModel()->getDoorTile();

        parent::__construct($id, $room, $doorTile);
        
        $this->type = match (true) {
            $this instanceof UserEntity => RoomEntityType::User,
        };

        $this->bodyRotation = $doorTile->getPosition()->calculateRotation($this->getPosition());
        $this->headRotation = $this->bodyRotation;
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

    public function moveTo(int $x, int $y): void
    {
        $roomTile = $this->getRoom()->getModel()->getTile($x, $y);

        if(empty($roomTile) || in_array($roomTile->getState(), [RoomTileState::Invalid, RoomTileState::Blocked])) return;

        $path = Pathfinder::getInstance()->makePath($this, $roomTile);

        if(empty($path)) return;

        $this->previousSteps = 0;

        $this->setWalkingPath($path);
    }

    public function isWalking(): bool
    {
        return !empty($this->getProcessingPath());
    }

    public function incrementPreviousStep(): void
    {
        $this->previousSteps++;
    }

    public function getPreviousStep(): int
    {
        return $this->previousSteps;
    }

    public function calculateNextRotation(Position $position): int
    {
        return $this->getPosition()->calculateRotation($position);
    }

    public function setNeedsUpdate(bool $needsUpdate): void
    {
        $this->needsUpdate = $needsUpdate;
    }

    public function getAndRemoveNextTile(): RoomTile
    {
        $nextProcessingPath = array_shift($this->processingPath);

        return $nextProcessingPath;
    }

    public function getNeedsUpdate(): bool
    {
        return $this->needsUpdate;
    }

    public function setNextTile(RoomTile $tile): void
    {
        $this->nextTile = $tile;
    }

    public function getNextTile(): ?RoomTile
    {
        return $this->nextTile;
    }
}