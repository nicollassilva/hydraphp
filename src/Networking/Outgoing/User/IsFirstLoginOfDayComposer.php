<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class IsFirstLoginOfDayComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$isFirstLoginOfDayComposer;

        $this->writeBoolean(true);
    }
}