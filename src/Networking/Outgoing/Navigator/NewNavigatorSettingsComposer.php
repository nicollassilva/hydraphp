<?php

namespace Emulator\Networking\Outgoing\Navigator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class NewNavigatorSettingsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$newNavigatorSettingsComposer;

        $this->writeInt32(100);
        $this->writeInt32(100);
        $this->writeInt32(425);
        $this->writeInt32(535);
        $this->writeBoolean(false);
        $this->writeInt32(0);
    }
}