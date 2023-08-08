<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserHomeRoomComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userHomeRoomComposer;

        $this->writeInt(0);
        $this->writeInt(0);
    }
}