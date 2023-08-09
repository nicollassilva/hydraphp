<?php

namespace Emulator\Game\Rooms\Utils\Pathfinder;

use Emulator\Game\Rooms\Data\RoomTile;
use Emulator\Game\Utilities\Position;

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

    public function setPosition(Position $position): void
    {
        $this->position = $position;
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

    public function setInClosed(bool $inClosed): void
    {
        $this->inClosed = $inClosed;
    }

    public function equals($obj): bool
    {
        return ($obj instanceof PathfinderNode) && ($obj->getPosition()->equals($this->position));
    }

    public function compareTo($o): int
    {
        return $this->cost <=> $o->getCost();
    }
}
