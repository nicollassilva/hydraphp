<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class IgnoredUsersComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$ignoredUsersComposer;

        $this->writeInt32(0);
    }
}