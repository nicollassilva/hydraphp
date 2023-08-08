<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserCurrencyComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userCurrencyComposer;

        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(5);
        $this->writeInt(100);
        $this->writeInt(101);
        $this->writeInt(0);
    }
}