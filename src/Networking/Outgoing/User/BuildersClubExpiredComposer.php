<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class BuildersClubExpiredComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$buildersClubExpiredComposer;

        $this->writeInt32(2147483647);
        $this->writeInt32(0);
        $this->writeInt32(100);
        $this->writeInt32(2147483647);
        $this->writeInt32(0);
    }
}