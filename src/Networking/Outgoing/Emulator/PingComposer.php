<?php

namespace Emulator\Networking\Outgoing\Emulator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class PingComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$pingComposer;
    }
}