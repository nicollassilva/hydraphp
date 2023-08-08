<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class BuildersClubExpiredComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$buildersClubExpiredComposer;

        $this->writeInt(2147483647);
        $this->writeInt(0);
        $this->writeInt(100);
        $this->writeInt(2147483647);
        $this->writeInt(0);
    }
}