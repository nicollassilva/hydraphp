<?php

namespace Emulator\Networking\Outgoing\Handshake;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class SecureLoginOkComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$secureLoginOkComposer;
    }
}