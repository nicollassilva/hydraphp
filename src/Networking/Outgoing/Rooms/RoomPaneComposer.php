<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomPaneComposer extends MessageComposer
{
    public function __construct(IRoom &$room, bool $isOwner)
    {
        $this->header = OutgoingHeaders::$roomPaneComposer;

        $this->writeInt($room->getData()->getId());
        $this->writeBoolean($isOwner);
    }
}