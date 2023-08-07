<?php

namespace Emulator\Api\Game\Rooms\Types\Entities;

use Emulator\Game\Rooms\Enums\RoomEntityType;
use Emulator\Game\Utilities\Position;

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

    public function isWalking(): bool;
    public function incrementPreviousStep(): void;
    public function getPreviousStep(): int;
    public function setFutureStep(Position $futurePosition): void;
    public function getFutureStep(): ?Position;
}