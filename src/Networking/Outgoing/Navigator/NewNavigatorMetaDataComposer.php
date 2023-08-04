<?php

namespace Emulator\Networking\Outgoing\Navigator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class NewNavigatorMetaDataComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$newNavigatorMetaDataComposer;

        $this->writeInt32(4);
        $this->writeString("official_view");
        $this->writeInt32(0);
        $this->writeString("hotel_view");
        $this->writeInt32(0);
        $this->writeString("roomads_view");
        $this->writeInt32(0);
        $this->writeString("myworld_view");
        $this->writeInt32(0);
    }
}