<?php

namespace Emulator\Api\Game\Rooms;

use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Types\Entities\RoomEntity;
use Emulator\Api\Game\Rooms\Data\{IRoomData,IRoomModel};

interface IRoom
{
    public function getData(): IRoomData;
    public function getModel(): IRoomModel;

    public function isOwner(IUser $user): bool;
    
    public function addEntity(RoomEntity &$entity): void;
}