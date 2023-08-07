<?php

namespace Emulator\Api\Game\Utilities\Pathfinder;

use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Types\Entities\RoomEntity;

interface IPathfinder
{
    public function findPath(RoomEntity $entity, Position $position);
}