<?php

namespace Emulator\Networking\Outgoing\Navigator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class NewNavigatorSavedSearchesComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$newNavigatorSavedSearchesComposer;

        $this->writeInt(0);
    }
}