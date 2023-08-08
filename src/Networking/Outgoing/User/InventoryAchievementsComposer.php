<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class InventoryAchievementsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$inventoryAchievementsComposer;

        $this->writeInt(0);
    }
}