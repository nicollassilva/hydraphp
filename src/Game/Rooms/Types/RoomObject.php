<?php

namespace Emulator\Game\Rooms\Types;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\Position;
use Emulator\Api\Game\Rooms\Types\IRoomObject;
use Emulator\Api\Game\Utilities\IPositionable;

class RoomObject implements IRoomObject, IPositionable
{
    private Position $position;

    public function __construct(
        private readonly int $id,
        private readonly IRoom $room,
        Position $startPosition
    ) {
        $this->position = $startPosition;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoom(): IRoom
    {
        return $this->room;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }
}