<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RecyclerLogicComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$recyclerLogicComposer;

        $this->writeInt(0);
    }
}