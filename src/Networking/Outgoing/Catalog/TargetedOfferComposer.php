<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class TargetedOfferComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$targetedOfferComposer;

        // TODO: Implement this
    }
}