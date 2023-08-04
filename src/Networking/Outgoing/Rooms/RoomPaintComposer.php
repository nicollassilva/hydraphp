<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomPaintComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$roomPaintComposer;

        $this->writeString('landscape');
        $this->writeString('0.0');
    }
}