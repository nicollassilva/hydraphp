<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomModelComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$roomModelComposer;

        $this->writeString('model_a');
        $this->writeString(1);
    }
}