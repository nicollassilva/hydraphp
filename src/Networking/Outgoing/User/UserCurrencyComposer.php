<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserCurrencyComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userCurrencyComposer;

        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(5);
        $this->writeInt32(100);
        $this->writeInt32(101);
        $this->writeInt32(0);
    }
}