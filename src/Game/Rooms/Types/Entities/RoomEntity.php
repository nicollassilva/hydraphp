<?php

namespace Emulator\Game\Rooms\Types\Entities;

use CometProject\Server\Game\Rooms\Objects\Entities\Pathfinding\Pathfinder;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Types\RoomObject;
use Emulator\Api\Game\Utilities\IMoveable;
use Emulator\Game\Rooms\Enums\RoomEntityType;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Api\Game\Rooms\Types\Entities\IRoomEntity;
use Emulator\Game\Rooms\Data\RoomTile;
use Emulator\Game\Rooms\Enums\RoomTileState;

class RoomEntity extends RoomObject implements IRoomEntity, IMoveable
{
    private RoomEntityType $type;

    private int $bodyRotation;
    private int $headRotation;

    private array $processingPath = [];
    private array $walkingPath = [];

    private int $previousSteps = 0;

    private ?Position $futureStep = null;

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

    public function moveTo(int $x, int $y): void
    {
        $roomTile = $this->getRoom()->getModel()->getTile($x, $y);

        if(empty($roomTile) || in_array($roomTile->getState(), [RoomTileState::Invalid, RoomTileState::Blocked])) return;

        $path = Pathfinder::getInstance()->makePath($this, new Position($x, $y, 0));

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

    public function setFutureStep(Position $futurePosition): void
    {
        $this->futureStep = $futurePosition;
    }

    public function getFutureStep(): ?Position
    {
        return $this->futureStep;
    }
}