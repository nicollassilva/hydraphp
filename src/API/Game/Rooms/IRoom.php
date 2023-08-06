<?php

namespace Emulator\Api\Game\Rooms;

use Emulator\Api\Game\Rooms\Data\{IRoomData,IRoomModel};

interface IRoom
{
    public function getData(): IRoomData;
    public function getModel(): IRoomModel;
}