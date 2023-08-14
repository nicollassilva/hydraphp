<?php

namespace Emulator\Game\Navigator\Search;

use ArrayObject;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Rooms\Enums\RoomState;
use Emulator\Api\Game\Utilities\IComposable;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Game\Navigator\Enums\{NavigatorDisplayMode,NavigatorDisplayOrder,NavigatorSearchAction,NavigatorListMode};

class NavigatorSearchList implements IComposable
{
    /** @property ArrayObject<int,IRoom> $rooms */
    private ArrayObject $rooms;

    public function __construct(
        private readonly int $order,
        private readonly string $category,
        private readonly string $search,
        private readonly NavigatorSearchAction $searchAction,
        private readonly NavigatorListMode $listMode,
        private readonly NavigatorDisplayMode $displayMode,
        private readonly bool $filtered,
        private readonly bool $showInvisibleRooms,
        private readonly NavigatorDisplayOrder $displayOrder,
        private readonly int $categoryOrder,
        ArrayObject $rooms
    ) {
        $this->rooms = $rooms;
    }

    public function compose(IMessageComposer $message): void
    {
        $message->writeString($this->category);
        $message->writeString($this->search);
        $message->writeInt($this->searchAction->value);
        $message->writeBoolean($this->displayMode === NavigatorDisplayMode::Collapsed);
        $message->writeInt($this->listMode->value);

        if(!$this->showInvisibleRooms) {
            foreach ($this->rooms as $room) {
                if($room->getData()->getState() !== RoomState::Invisible) continue;
                
                $this->rooms->offsetUnset($room->getData()->getId());
            }
        }

        $message->writeInt($this->rooms->count());

        foreach ($this->rooms as $room) {
            $room->compose($message);
        }
    }

    /** @return ArrayObject<int,IRoom> */
    public function getRooms(): ArrayObject
    {
        return $this->rooms;
    }
}