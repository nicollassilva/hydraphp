<?php

namespace Emulator\Api\Game\Rooms\Types;

use Emulator\Api\Game\Rooms\IRoom;

interface IRoomObject
{
    public function getId(): int;
    public function getRoom(): ?IRoom;
}