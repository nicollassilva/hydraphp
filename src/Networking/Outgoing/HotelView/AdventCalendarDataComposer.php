<?php

namespace Emulator\Networking\Outgoing\HotelView;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class AdventCalendarDataComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$adventCalendarDataComposer;

        $this->writeString("xmas14");
        $this->writeString("");
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
    }
}