<?php

namespace Emulator\Networking\Outgoing\HotelView;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class HotelViewDataComposer extends MessageComposer
{
    public function __construct(string $key, string $data)
    {
        $this->header = OutgoingHeaders::$hotelViewDataComposer;

        $this->writeString($key);
        $this->writeString($data);
    }
}