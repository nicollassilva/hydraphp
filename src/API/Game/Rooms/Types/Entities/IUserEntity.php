<?php

namespace Emulator\Api\Game\Rooms\Types\Entities;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Enums\{RoomRightLevels,RoomEntityStatus};

interface IUserEntity
{
    public function getUser(): IUser;
    public function getLogger(): Logger;

    public function isKicked(): bool;

    public function getStatus(): array;
    public function clearStatus(): void;
    public function setStatus(RoomEntityStatus $status, string $key): void;
    public function removeStatus(RoomEntityStatus $status): void;

    public function getRoomRightLevel(): RoomRightLevels;
    public function setRoomRightLevel(RoomRightLevels $roomRightLevel): void;
}