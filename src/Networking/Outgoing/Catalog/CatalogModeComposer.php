<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class CatalogModeComposer extends MessageComposer
{
    public function __construct(int $mode)
    {
        $this->header = OutgoingHeaders::$catalogModeComposer;

        $this->writeInt($mode);
    }
}