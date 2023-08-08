<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomHeightmapComposer extends MessageComposer
{
    public function __construct(IRoom &$room)
    {
        $this->header = OutgoingHeaders::$roomHeightmapComposer;

        $this->writeBoolean(true);
        $this->writeInt($room->getData()->getWallHeight());
        $this->writeString($room->getModel()->getRelativeMap());
    }
}