<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomScoreComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$roomScoreComposer;

        $this->writeInt32(1);
        $this->writeBoolean(true);
    }
}