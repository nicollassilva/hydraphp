<?php

namespace Emulator\Networking\Outgoing\Messenger;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class MessengerInitComposer extends MessageComposer
{
    private int $maxFriends = 300;
    private int $maxFriendsHc = 500;

    public function __construct()
    {
        $this->header = OutgoingHeaders::$messengerInitComposer;

        $this->writeInt32($this->maxFriends);
        $this->writeInt32(1337);
        $this->writeInt32($this->maxFriendsHc);
        $this->writeInt32(0);
    }
}