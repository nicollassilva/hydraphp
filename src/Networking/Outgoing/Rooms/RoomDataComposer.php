<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Game\Rooms\RoomManager;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomDataComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$roomDataComposer;

        $this->writeBoolean(false);
        $this->writeInt32(1);
        $this->writeString('PHP Emulator');
        $this->writeInt32(1);
        $this->writeString('iNicollas');
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(20);
        $this->writeString('Emulator made with PHP');
        $this->writeInt32(0);
        $this->writeInt32(1);
        $this->writeInt32(2);
        $this->writeInt32(1);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeBoolean(true);
        $this->writeBoolean(true);
        $this->writeBoolean(false);
        $this->writeBoolean(false);
        $this->writeBoolean(false);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeBoolean(false);
        $this->writeInt32(0);
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeInt32(50);
        $this->writeInt32(2);
    }
}