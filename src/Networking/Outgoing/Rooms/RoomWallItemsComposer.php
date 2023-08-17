<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomWallItemsComposer extends MessageComposer
{
    public function __construct(IRoom &$room)
    {
        $this->header = OutgoingHeaders::$roomWallItemsComposer;

        $this->writeInt($room->getItemComponent()->getWallItemsOwnerNames()->count());

        foreach ($room->getItemComponent()->getWallItemsOwnerNames() as $ownerId => $ownerName) {
            $this->writeInt($ownerId);
            $this->writeString($ownerName);
        }

        $this->writeInt($room->getItemComponent()->getWallItems()->count());

        foreach ($room->getItemComponent()->getWallItems() as $wallItem) {
            $wallItem->compose($this);
        }
    }
}