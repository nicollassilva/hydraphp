<?php

namespace Emulator\Api\Game\Rooms\Types\Entities;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Enums\RoomRightLevels;

interface IUserEntity
{
    public function getUser(): IUser;
    public function isKicked(): bool;

    public function getRoomRightLevel(): RoomRightLevels;
    public function setRoomRightLevel(RoomRightLevels $roomRightLevel): void;

    public function setRoom(?IRoom $room): void;

    public function setIsKicked(bool $isKicked): void;
}