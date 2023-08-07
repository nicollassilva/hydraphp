<?php

namespace Emulator\Networking\Outgoing\Inventory;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class InventoryRefreshComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$inventoryRefreshComposer;
    }
}