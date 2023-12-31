<?php

namespace Emulator\Game\Rooms\Data;

use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Enums\RoomTileState;

class RoomTile
{
    private RoomTileState $state;
    
    private bool $canStack;
    private float $stackHeight;

    private ?RoomTile $previousTile = null;

    public function __construct(
        private readonly Position $position,
        RoomTileState &$state = RoomTileState::Invalid,
        bool $allowStack = true
    ) {
        $this->state = $state;
        $this->stackHeight = $position->getZ();
        $this->canStack = $allowStack;

        if($state === RoomTileState::Invalid) {
            $this->canStack = false;
        }
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): void
    {
        // Position is readonly.
    }

    public function getStackHeight(): float
    {
        return $this->stackHeight;
    }

    public function getCanStack(): bool
    {
        return $this->canStack;
    }

    public function setCanStack(bool $canStack): void
    {
        $this->canStack = $canStack;
    }

    public function getState(): RoomTileState
    {
        return $this->state;
    }

    public function setState(RoomTileState $state): void
    {
        $this->state = $state;
    }

    public function getRelativeHeight(): float
    {
        if($this->getState() === RoomTileState::Invalid) {
            return (float) (pow(2, 15) - 1);
        }

        if(!$this->getCanStack() && ($this->getState() === RoomTileState::Blocked || $this->getState() === RoomTileState::Sit)) {
            return pow(128, 2);
        }

        return $this->getCanStack() ? (float) ($this->getStackHeight() * 256) : pow(128, 2);
    }

    public function getWalkHeight(): float
    {
        return $this->getPosition()->getZ();
    }

    public function setPreviousTile(RoomTile $previousTile): void
    {
        $this->previousTile = $previousTile;
    }

    public function setStackHeight(float $stackHeight): void
    {
        if($this->state === RoomTileState::Invalid) {
            $this->stackHeight = (pow(2, 15) - 1);
            $this->canStack = false;
            return;
        }

        if($stackHeight >= 0 && $this->stackHeight != (pow(2, 15) - 1)) {
            $this->stackHeight = $stackHeight;
            $this->canStack = true;
            return;
        }

        $this->canStack = false;
        $this->stackHeight = $this->getPosition()->getZ();
    }

    public function getPreviousTile(): RoomTile
    {
        return $this->previousTile;
    }

    public function isEquals(RoomTile $tileToCompare): bool
    {
        return $this->getPosition()->isEquals($tileToCompare->getPosition());
    }
}