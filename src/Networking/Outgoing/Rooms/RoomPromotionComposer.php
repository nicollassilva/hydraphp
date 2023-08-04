<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomPromotionComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$roomPromotionComposer;

        $this->writeInt32(-1);
        $this->writeInt32(-1);
        $this->writeString("");
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeString("");
        $this->writeString("");
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
    }
}