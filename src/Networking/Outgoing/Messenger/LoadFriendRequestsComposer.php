<?php

namespace Emulator\Networking\Outgoing\Messenger;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class LoadFriendRequestsComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$loadFriendRequestsComposer;

        $this->writeInt(0);
        $this->writeInt(0);
    }
}