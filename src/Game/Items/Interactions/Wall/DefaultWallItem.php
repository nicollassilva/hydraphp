<?php

namespace Emulator\Game\Items\Interactions\Wall;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Items\Data\RoomWallItem;

class DefaultWallItem extends RoomWallItem
{
    public function __construct(array &$data, IRoom $room)
    {
        parent::__construct($data, $room);
    }
}