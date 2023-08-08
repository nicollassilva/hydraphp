<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomThicknessComposer extends MessageComposer
{
    public function __construct(IRoom &$room)
    {
        $this->header = OutgoingHeaders::$roomThicknessComposer;

        $this->writeBoolean($room->getData()->isHideWall());
        $this->writeInt($room->getData()->getThicknessWall());
        $this->writeInt($room->getData()->getThicknessFloor());
    }
}