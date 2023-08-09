<?php

namespace Emulator\Networking\Outgoing\Catalog\Marketplace;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class MarketplaceConfigComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$marketplaceConfigComposer;

        $this->writeBoolean(true);
        $this->writeInt(1);
        $this->writeInt(10);
        $this->writeInt(5);
        $this->writeInt(1);
        $this->writeInt(1000000);
        $this->writeInt(48);
        $this->writeInt(7);
    }
}