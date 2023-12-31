<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class CfhTopicsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$cfhTopicsComposer;

        $this->writeInt(0);
    }
}