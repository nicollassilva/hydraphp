<?php

namespace Emulator\Game\Rooms\Components;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Types\RoomObject;
use Emulator\Api\Game\Rooms\Data\IRoomModel;

class MappingComponent
{
    private const MAX_WALKABLE_HEIGHT_DIFFERENCE = 1.2;

    public function __construct(
        private readonly IRoom $room
    ) {}

    public function getRoom(): IRoom
    {
        return $this->room;
    }

    public function getRoomModel(): IRoomModel
    {
        return $this->getRoom()->getModel();
    }

    public function isValidEntityStep(
        RoomObject $object, 
        Position $from, 
        Position $to, 
        bool $isLastStep, 
        bool $isRetry
    ): bool {
        return $this->checkStepValidation($object->getVirtualId(), $from, $to, $isLastStep, false, $isRetry, false, false);
    }
    
    public function isValidStep(
        RoomObject $object,
        Position $from,
        Position $to,
        bool $isLastStep,
        bool $isRetry
    ): bool {
        return false;
    }

    private function checkStepValidation(
        ?int $roomEntityId,
        Position $from,
        Position $to,
        bool $isLastStep,
        bool $isFloorItem,
        bool $isRetry,
        bool $ignoreHeight,
        bool $isItemOnRoller
    ): bool {
        if($from->getX() === $to->getX() && $from->getY() === $to->getY()) {
            return false;
        }

        if(!($to->getX() < $this->getRoomModel()->getTilesLength())) {
            return false;
        }

        if(!$this->getRoomModel()->isValid($to) || $this->getRoomModel()->positionIsDoor($to)) {
            return false;
        }

        // check rotation here

        // check position has user here

        if($this->getRoomModel()->positionIsDoor($to)) {
            return true;
        }

        if($ignoreHeight) {
            return true;
        }

        $fromHeight = $this->getPositionHeight($from);
        $toHeight = $this->getPositionHeight($to);

        if($fromHeight > $toHeight) {
            return $roomEntityId !== null || $fromHeight - $toHeight >= 3;
        }

        return !($fromHeight < $toHeight && ($toHeight - $fromHeight > self::MAX_WALKABLE_HEIGHT_DIFFERENCE));
    }

    public function getPositionHeight(Position $position): float
    {
        if(
            $this->getRoomModel()->getTilesLength() <= $position->getX()
            || count($this->getRoomModel()->getTiles($position->getX())) <= $position->getY()
            || !$this->getRoomModel()->isValid($position)
        ) {
            return 0;
        }

        return $this->getRoomModel()->getTile($position->getX(), $position->getY())->getWalkHeight();
    }
}