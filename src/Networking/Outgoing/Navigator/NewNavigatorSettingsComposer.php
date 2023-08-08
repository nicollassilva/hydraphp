<?php

namespace Emulator\Networking\Outgoing\Navigator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class NewNavigatorSettingsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$newNavigatorSettingsComposer;

        $this->writeInt(100);
        $this->writeInt(100);
        $this->writeInt(425);
        $this->writeInt(535);
        $this->writeBoolean(false);
        $this->writeInt(0);
    }
}