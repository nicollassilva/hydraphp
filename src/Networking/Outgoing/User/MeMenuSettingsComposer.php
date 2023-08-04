<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class MeMenuSettingsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$meMenuSettingsComposer;

        $this->writeInt32(100);
        $this->writeInt32(100);
        $this->writeInt32(100);
        $this->writeBoolean(false);
        $this->writeBoolean(false);
        $this->writeBoolean(true);
        $this->writeInt32(0);
        $this->writeInt32(0);
    }
}