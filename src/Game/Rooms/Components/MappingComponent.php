<?php

namespace Emulator\Game\Rooms\Components;

use ArrayObject;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Data\RoomTile;
use Emulator\Game\Rooms\Types\RoomObject;
use Emulator\Api\Game\Items\Data\IRoomItem;
use Emulator\Api\Game\Rooms\Data\IRoomModel;
use Emulator\Game\Rooms\Enums\RoomTileState;

class MappingComponent
{
    private const MAX_WALKABLE_HEIGHT_DIFFERENCE = 1.2;

    private bool $heightmapLoaded = false;

    public function __construct(
        private readonly IRoom $room
    ) {
    }

    public function getRoom(): IRoom
    {
        return $this->room;
    }

    public function getRoomModel(): IRoomModel
    {
        return $this->getRoom()->getModel();
    }

    public function loadRoomHeighmap(): void
    {
        if($this->heightmapLoaded) return;

        $this->heightmapLoaded = true;
        
        for ($x = 0; $x < $this->getRoomModel()->getMapSizeX(); $x++) {
            for ($y = 0; $y < $this->getRoomModel()->getMapSizeY(); $y++) {
                $this->updateTile($this->getRoomModel()->getTile($x, $y));
            }
        }
    }

    public function updateTile(?RoomTile $tile): void
    {
        if (!($tile instanceof RoomTile)) return;

        $tile->setStackHeight($this->getStackHeightForPosition($tile->getPosition(), false));
        $tile->setState($this->calculateTileState($tile));
    }

    public function getStackHeightForPosition(Position $position, bool $keepHeightmap = true): float
    {
        if ($position->getX() < 0 || $position->getY() < 0 || is_null($this->getRoomModel())) {
            return $keepHeightmap ? (pow(2, 15) - 1) : 0;
        }

        $height = $this->getRoomModel()->getTile($position->getX(), $position->getY())->getPosition()->getZ();
        $canStack = true;

        if ($topItem = $this->getTopItemAt($position)) {
            $canStack = $topItem->getItemDefinition()->isAllowStack();
            $height = $topItem->getData()->getZ();

            if ($topItem->getItemDefinition()->isAllowSit()) {
                $height += $topItem->getItemDefinition()->getStackHeight();
            }
        }

        if ($keepHeightmap) {
            return $canStack ? $height * 256 : (pow(2, 15) - 1);
        }

        return $canStack ? $height : -1;
    }

    public function getTopItemAt(Position $position): ?IRoomItem
    {
        /** @var IRoomItem $highestItem */
        $highestItem = null;

        foreach ($this->getItemsAt($position) as $item) {
            if (is_null($highestItem)) {
                $highestItem = $item;
                continue;
            }

            if (($highestItem->getData()->getZ() + $highestItem->getItemDefinition()->getStackHeight()) > ($item->getData()->getZ() + $item->getItemDefinition()->getStackHeight()))
                continue;

            $highestItem = $item;
        }

        return $highestItem;
    }

    /** @return ArrayObject<int,IRoomItem> */
    public function getItemsAt(Position $position, bool $returnFirstItem = false): ArrayObject
    {
        /** @var ArrayObject<int,IRoomItem> $items */
        $items = new ArrayObject;

        foreach ($this->getRoom()->getItemComponent()->getFloorItems() as $item) {
            $width = 1;
            $length = 1;

            if ($item->getData()->getRotation() != 2 && $item->getData()->getRotation() != 6) {
                $width = $item->getItemDefinition()->getWidth() > 0 ? $item->getItemDefinition()->getWidth() : 1;
                $length = $item->getItemDefinition()->getLength() > 0 ? $item->getItemDefinition()->getLength() : 1;
            }
            else {
                $width = $item->getItemDefinition()->getLength() > 0 ? $item->getItemDefinition()->getLength() : 1;
                $length = $item->getItemDefinition()->getWidth() > 0 ? $item->getItemDefinition()->getWidth() : 1;
            }

            if (!(
                $position->getX() >= $item->getData()->getX() && $position->getX() <= $item->getData()->getX() + $width - 1 &&
                $position->getY() >= $item->getData()->getY() && $position->getY() <= $item->getData()->getY() + $length - 1
            )) continue;

            $items->offsetSet($item->getVirtualId(), $item);

            if($returnFirstItem) return $items;
        }

        return $items;
    }

    public function calculateTileState(RoomTile $tile): RoomTileState
    {
        if ($tile->getState() === RoomTileState::Invalid) {
            return RoomTileState::Invalid;
        }

        $tileState = RoomTileState::Open;

        $items = $this->getItemsAt($tile->getPosition());

        if(!$items->count()) {
            return RoomTileState::Open;
        }

        $tallestItem = null;

        foreach ($items as $item) {
            if($item->getItemDefinition()->isAllowLay()) {
                return RoomTileState::Lay;
            }

            if (!is_null($tallestItem) && ($tallestItem->getData()->getZ() + $tallestItem->getItemDefinition()->getStackHeight()) > ($item->getData()->getZ() + $item->getItemDefinition()->getStackHeight()))
                continue;

            $tileState = $this->checkStateFromRoomItem($item);
            $tallestItem = $item;
        }

        unset($tallestItem, $items);

        return $tileState;
    }

    private function checkStateFromRoomItem(IRoomItem &$item): RoomTileState
    {
        return match (true) {
            $item->getItemDefinition()->isAllowWalk() => RoomTileState::Open,
            $item->getItemDefinition()->isAllowSit() => RoomTileState::Sit,
            $item->getItemDefinition()->isAllowLay() => RoomTileState::Lay,
            default => RoomTileState::Blocked
        };
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
        if ($from->getX() === $to->getX() && $from->getY() === $to->getY()) {
            return false;
        }

        if (!($to->getX() < $this->getRoomModel()->getTilesLength())) {
            return false;
        }

        if (!$this->getRoomModel()->isValid($to) || $this->getRoomModel()->positionIsDoor($to)) {
            return false;
        }

        // check rotation here

        // check position has user here

        if ($this->getRoomModel()->positionIsDoor($to)) {
            return true;
        }

        if ($ignoreHeight) {
            return true;
        }

        $fromHeight = $this->getPositionHeight($from);
        $toHeight = $this->getPositionHeight($to);

        if ($fromHeight > $toHeight) {
            return $roomEntityId !== null || $fromHeight - $toHeight >= 3;
        }

        return !($fromHeight < $toHeight && ($toHeight - $fromHeight > self::MAX_WALKABLE_HEIGHT_DIFFERENCE));
    }

    public function getPositionHeight(Position $position): float
    {
        if (
            $this->getRoomModel()->getTilesLength() <= $position->getX()
            || count($this->getRoomModel()->getTiles($position->getX())) <= $position->getY()
            || !$this->getRoomModel()->isValid($position)
        ) {
            return 0;
        }

        return $this->getRoomModel()->getTile($position->getX(), $position->getY())->getWalkHeight();
    }
}
