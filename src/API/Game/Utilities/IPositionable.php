<?php

namespace Emulator\Api\Game\Utilities;

use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Data\RoomTile;

interface IPositionable
{
    public function getPosition(): Position;
    public function getCurrentTile(): RoomTile;
    public function setCurrentTile(RoomTile $tile): void;
}