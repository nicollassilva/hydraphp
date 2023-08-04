<?php

namespace Emulator\Networking\Outgoing\Emulator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class AvailabilityStatusComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$availabilityStatusComposer;

        $this->writeBoolean(true);
        $this->writeBoolean(false);
        $this->writeBoolean(true);
    }
}