<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class MysteryBoxKeysComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$mysteryBoxKeysComposer;

        $this->writeString("");
        $this->writeString("");
    }
}