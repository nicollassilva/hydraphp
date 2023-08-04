<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class ModToolSanctionInfoComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$modToolSanctionInfoComposer;

        $this->writeBoolean(false);
        $this->writeBoolean(false);
        $this->writeString("ALERT");
        $this->writeInt32(0);
        $this->writeInt32(30);
        $this->writeString("cfh.reason.EMPTY");
        $this->writeString("23-12-2019 12:00:00");
        $this->writeInt32(0);
        $this->writeString("ALERT");
        $this->writeInt32(0);
        $this->writeInt32(30);
        $this->writeBoolean(false);
        $this->writeString("");
    }
}