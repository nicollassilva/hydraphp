<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomFloorItemsComposer extends MessageComposer
{
    public function __construct(IRoom &$room)
    {
        $this->header = OutgoingHeaders::$roomFloorItemsComposer;

        $this->writeInt($room->getItemComponent()->getFloorItemsOwnerNames()->count());

        foreach ($room->getItemComponent()->getFloorItemsOwnerNames() as $ownerId => $ownerName) {
            $this->writeInt($ownerId);
            $this->writeString($ownerName);
        }

        $this->writeInt($room->getItemComponent()->getFloorItems()->count());

        foreach ($room->getItemComponent()->getFloorItems() as $item) {
            $item->compose($this);
            $this->writeInt(1);
            $item->composeExtraData($this);
            $this->writeInt(-1);
            $this->writeInt(1);
            $this->writeInt($item->getData()->getOwnerId());
        }
    }
}