<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class EnableNotificationsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$enableNotificationsComposer;

        $this->writeBoolean(true);
    }
}