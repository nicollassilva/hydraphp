<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class PrivateRoomsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$privateRoomsComposer;

        $this->writeInt32(2);
        $this->writeString("");
        $this->writeInt32(0);
        $this->writeBoolean(true);
        $this->writeInt32(0);
        $this->writeString("A");
        $this->writeString("B");
        $this->writeInt32(1);
        $this->writeString("C");
        $this->writeString("D");
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeString("E");
    }
}