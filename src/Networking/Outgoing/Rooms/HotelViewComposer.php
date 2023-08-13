<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class HotelViewComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$hotelViewComposer;
    }
}