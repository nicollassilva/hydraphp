<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomUserStatusComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$roomUserStatusComposer;

        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeInt32(2);
        $this->writeInt32(2);
        $this->writeString("");
    }
}