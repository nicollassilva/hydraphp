<?php

namespace Emulator\Api\Game\Rooms;

use Emulator\Api\Game\Rooms\Data\IRoomData;

interface IRoom
{
    public function getData(): IRoomData;
}