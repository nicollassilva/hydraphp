<?php

namespace Emulator\Networking\Outgoing\Inventory;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class InventoryRefreshComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$inventoryRefreshComposer;

        $this->writeString('habbo_club');
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeBoolean(false);
        $this->writeBoolean(false);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
    }
}