<?php

namespace Emulator\Networking\Outgoing\Navigator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class NewNavigatorEventCategoriesComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$newNavigatorEventCategoriesComposer;

        $this->writeInt32(0);
    }
}