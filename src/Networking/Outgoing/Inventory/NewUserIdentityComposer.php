<?php

namespace Emulator\Networking\Outgoing\Inventory;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class NewUserIdentityComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$newUserIdentityComposer;

        $this->writeInt32(1);
    }
}