<?php

namespace Emulator\Api\Game\Items\Data;

interface IRoomItemData
{
    public function getId(): int;

    public function getOwnerId(): int;

    public function getOwnerName(): string;

    public function getRoomId(): int;

    public function getItemDefinitionId(): int;

    public function getWallPosition(): string;

    public function getX(): int;

    public function getY(): int;

    public function getZ(): float;

    public function getRotation(): int;

    public function getExtraData(): string;

    public function getWiredData(): string;

    public function getLimitedData(): string;

    public function getGroupId(): int;

    public function getLimitedStack(): int;

    public function getLimitedSells(): int;
    
    public function isLimitedEdition(): bool;
}