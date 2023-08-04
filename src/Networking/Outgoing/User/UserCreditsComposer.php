<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserCreditsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userCreditsComposer;

        $this->writeString("5000.0");
    }
}