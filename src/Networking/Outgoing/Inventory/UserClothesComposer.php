<?php

namespace Emulator\Networking\Outgoing\Inventory;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserClothesComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userClothesComposer;

        $this->writeInt32(0);
        $this->writeInt32(0);
    }
}