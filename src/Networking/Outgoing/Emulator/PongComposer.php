<?php

namespace Emulator\Networking\Outgoing\Emulator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class PongComposer extends MessageComposer
{
    public function __construct(int $id)
    {
        $this->header = OutgoingHeaders::$pongComposer;

        $this->writeInt($id);
    }
}