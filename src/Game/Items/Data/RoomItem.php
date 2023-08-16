<?php

namespace Emulator\Game\Items\Data;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Rooms\Data\RoomTile;
use Emulator\Game\Rooms\Types\RoomObject;
use Emulator\Api\Game\Items\Data\IRoomItem;

class RoomItem extends RoomObject implements IRoomItem
{
    public function __construct(
        int $identifier,
        IRoom $room,
        RoomTile $roomTile
    ) {
        parent::__construct($identifier, $room, $roomTile);
    }
}