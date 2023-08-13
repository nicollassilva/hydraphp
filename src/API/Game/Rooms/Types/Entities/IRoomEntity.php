<?php

namespace Emulator\Api\Game\Rooms\Types\Entities;

use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Data\RoomTile;
use Emulator\Game\Rooms\Enums\RoomEntityType;
use Emulator\Game\Rooms\Enums\RoomEntityStatus;

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

    public function calculateNextRotation(Position $position): int;

    public function setNeedsUpdate(bool $needsUpdate): void;
    public function getNeedsUpdate(): bool;

    public function getAndRemoveNextTile(): RoomTile;
    public function setNextTile(RoomTile $tile): void;
    public function getNextTile(): ?RoomTile;
    
    public function getStatus(): array;
    public function clearStatus(): void;
    public function hasStatus(RoomEntityStatus $status): bool;
    public function removeStatus(RoomEntityStatus $status): void;
    public function setStatus(RoomEntityStatus $status, string $key): void;

    public function dispose(): void;
}