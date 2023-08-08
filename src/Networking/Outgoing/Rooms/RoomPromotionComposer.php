<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomPromotionComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$roomPromotionComposer;

        $this->writeInt(-1);
        $this->writeInt(-1);
        $this->writeString("");
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeString("");
        $this->writeString("");
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
    }
}