<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class PrivateRoomsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$privateRoomsComposer;

        $this->writeInt(2);
        $this->writeString("");
        $this->writeInt(0);
        $this->writeBoolean(true);
        $this->writeInt(0);
        $this->writeString("A");
        $this->writeString("B");
        $this->writeInt(1);
        $this->writeString("C");
        $this->writeString("D");
        $this->writeInt(1);
        $this->writeInt(1);
        $this->writeInt(1);
        $this->writeString("E");
    }
}