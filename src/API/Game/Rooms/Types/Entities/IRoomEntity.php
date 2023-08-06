<?php

namespace Emulator\Api\Game\Rooms\Types\Entities;

use Emulator\Game\Rooms\Enums\RoomEntityType;

interface IRoomEntity
{
    public function getType(): RoomEntityType;

    public function getBodyRotation(): int;
    public function setBodyRotation(int $bodyRotation): void;

    public function getHeadRotation(): int;
    public function setHeadRotation(int $headRotation): void;

    public function getProcessingPath(): array;
    public function setProcessingPath(array $processingPath): void;
    
    public function getWalkingPath(): array;
    public function setWalkingPath(array $walkingPath): void;
}