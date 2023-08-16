<?php

namespace Emulator\Game\Rooms\Components;

use Emulator\Api\Game\Rooms\IRoom;

class ItemComponent
{
    private int $nextItemId = 0;

    public function __construct(private readonly IRoom $room)
    {

    }

    public function getNextItemId(): int
    {
        return ++$this->nextItemId;
    }
}