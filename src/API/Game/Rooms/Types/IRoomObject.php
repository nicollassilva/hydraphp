<?php

namespace Emulator\Api\Game\Rooms\Types;

use Emulator\Api\Game\Rooms\IRoom;

interface IRoomObject
{
    public function getVirtualId(): int;
    public function getRoom(): ?IRoom;
}