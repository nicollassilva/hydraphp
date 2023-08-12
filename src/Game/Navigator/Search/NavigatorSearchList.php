<?php

namespace Emulator\Game\Navigator\Search;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Utilities\IComposable;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Game\Navigator\Enums\{NavigatorDisplayMode,NavigatorDisplayOrder,NavigatorSearchAction,NavigatorListMode};
use Emulator\Game\Rooms\Enums\RoomState;

class NavigatorSearchList implements IComposable
{
    /** @var array<int,IRoom> */
    private array $rooms;

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
        array $rooms
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
                if($room->getData()->getState() != RoomState::Invisible) continue;
                
                unset($this->rooms[$room->getData()->getId()]);
            }
        }

        $message->writeInt(count($this->rooms));

        foreach ($this->rooms as $room) {
            $room->compose($message);
        }
    }

    /** @return array<int,IRoom> */
    public function getRooms(): array
    {
        return $this->rooms;
    }
}