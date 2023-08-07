<?php

namespace Emulator\Game\Rooms\Data;

use Emulator\Game\Utilities\Position;
use Emulator\Api\Game\Utilities\IPositionable;
use Emulator\Game\Rooms\Enums\RoomTileState;

class RoomTile implements IPositionable
{
    private RoomTileState $state;
    
    private bool $canStack;
    private int $stackHeight;

    public function __construct(
        private readonly Position $position,
        RoomTileState &$state = RoomTileState::Invalid
    ) {
        $this->state = $state;
        $this->stackHeight = $position->getZ();

        if($state != RoomTileState::Blocked || $state != RoomTileState::Blocked) {
            $this->canStack = true;
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

    public function getStackHeight(): int
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

    public function getRelativeHeight(): int
    {
        if($this->getState() == RoomTileState::Invalid) {
            return pow(2, 15) - 1;
        }

        if(!$this->getCanStack() && ($this->getState() == RoomTileState::Blocked || $this->getState() == RoomTileState::Sit)) {
            return pow(128, 2);
        }

        return $this->getCanStack() ? ($this->getStackHeight() * 256) : pow(128, 2);
    }
}