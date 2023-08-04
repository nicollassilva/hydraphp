<?php

namespace Emulator\Networking\Outgoing\Inventory;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserPermissionsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userPermissionsComposer;

        $this->writeInt32(2);
        $this->writeInt32(1);
        $this->writeBoolean(false);
    }
}