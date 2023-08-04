<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserDataComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userDataComposer;

        $this->writeInt32(1);
        $this->writeString("iNicollas");
        $this->writeString("hr-3090-42-61.hd-180-10-61.ch-804-82-61.lg-281-1408-61.sh-295-80-61");
        $this->writeString("M");
        $this->writeString("I Love Orion");
        $this->writeString("iNicollas");
        $this->writeBoolean(false);
        $this->writeInt32(1);
        $this->writeInt32(3);
        $this->writeInt32(3);
        $this->writeBoolean(false);
        $this->writeString("01-01-1970 00:00:00");
        $this->writeString(false);
        $this->writeString(false);
    }
}