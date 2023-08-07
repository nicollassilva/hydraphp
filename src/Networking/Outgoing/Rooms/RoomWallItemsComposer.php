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

        $this->writeInt32(0); // furni owner names count
        $this->writeInt32(0); // items count
    }
}