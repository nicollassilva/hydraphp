<?php

namespace Emulator\Networking\Outgoing\Inventory;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class InventoryEffectsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$inventoryEffectsComposer;

        $this->writeInt(0);
    }
}