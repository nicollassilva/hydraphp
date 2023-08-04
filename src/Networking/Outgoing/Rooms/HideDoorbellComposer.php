<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class HideDoorbellComposer extends MessageComposer
{
    public function __construct(string $username)
    {
        $this->header = OutgoingHeaders::$hideDoorbellComposer;

        $this->writeString($username);
    }
}