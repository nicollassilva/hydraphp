<?php

namespace Emulator\Game\Rooms\Utils\Pathfinder;

use Emulator\Game\Utilities\Position;

class PathfinderNode
{
    private $position;
    private $nextNode;

    private $cost = PHP_INT_MAX;
    private $inOpen = false;
    private $inClosed = false;

    public function __construct(Position $current)
    {
        $this->position = $current;
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
