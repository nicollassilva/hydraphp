<?php

namespace Emulator\Api\Game\Rooms\Components;

use Emulator\Api\Game\Rooms\IRoom;

interface IProcessComponent
{
    public function getRoom(): IRoom;
}