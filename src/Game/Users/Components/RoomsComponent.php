<?php

namespace Emulator\Game\Users\Components;

use ArrayObject;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Storage\Repositories\Users\UserRepository;

class RoomsComponent
{
    /** @property ArrayObject<int,IRoom> */
    private ArrayObject $ownRooms;

    public function __construct(
        private readonly IUser $user
    ) {
        $this->ownRooms = new ArrayObject;
        
        $this->loadOwnRooms();
    }

    private function loadOwnRooms(): void
    {
        UserRepository::loadOwnRooms($this->user, $this->ownRooms);
    }

    /** @return ArrayObject<int,IRoom> */
    public function getOwnRooms(): ArrayObject
    {
        return $this->ownRooms;
    }

    public function addOwnRoom(IRoom &$room): void
    {
        if($this->ownRooms->offsetExists($room->getData()->getId())) return;

        $this->ownRooms->offsetSet($room->getData()->getId(), $room);
    }
}