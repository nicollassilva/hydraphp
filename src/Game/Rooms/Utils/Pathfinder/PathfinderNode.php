<?php

namespace Emulator\Game\Rooms\Utils\Pathfinder;

use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Data\RoomTile;

class PathfinderNode
{
    private RoomTile $current;
    private Position $position;
    private ?PathfinderNode $nextNode = null;

    private int $cost;
    private bool $inOpen = false;
    private bool $inClosed = false;

    public function __construct(RoomTile $current, int $cost = PHP_INT_MAX)
    {
        $this->current = $current;
        $this->position = $current->getPosition();
        $this->cost = $cost;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function getNextNode(): ?PathfinderNode
    {
        return $this->nextNode;
    }

    public function getCurrent(): RoomTile
    {
        return $this->current;
    }

    public function setNextNode(?PathfinderNode $nextNode): void
    {
        $this->nextNode = $nextNode;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    public function isInOpen(): bool
    {
        return $this->inOpen;
    }

    public function setInOpen(bool $inOpen): void
    {
        $this->inOpen = $inOpen;
    }

    public function isInClosed(): bool
    {
        return $this->inClosed;
    }
}
