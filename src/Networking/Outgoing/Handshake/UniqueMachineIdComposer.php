<?php

namespace Emulator\Networking\Outgoing\Handshake;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UniqueMachineIdComposer extends MessageComposer
{
    public function __construct(string $uniqueId)
    {
        $this->header = OutgoingHeaders::$uniqueMachineIdComposer;

        $this->writeString($uniqueId);
    }
}