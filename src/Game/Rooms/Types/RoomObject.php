<?php

namespace Emulator\Game\Rooms\Types;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\Position;
use Emulator\Api\Game\Rooms\Types\IRoomObject;
use Emulator\Api\Game\Utilities\IPositionable;
use Emulator\Game\Rooms\Data\RoomTile;

class RoomObject implements IRoomObject, IPositionable
{
    private RoomTile $currentTile;

    private ?IRoom $room = null;

    public function __construct(
        private readonly int $id,
        IRoom $room,
        RoomTile $currentTile
    ) {
        $this->currentTile = $currentTile;
        $this->room = $room;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoom(): ?IRoom
    {
        return $this->room;
    }

    public function getPosition(): Position
    {
        return $this->currentTile->getPosition();
    }

    public function getCurrentTile(): RoomTile
    {
        return $this->currentTile;
    }

    public function setCurrentTile(RoomTile $tile): void
    {
        $this->currentTile = $tile;
    }
}