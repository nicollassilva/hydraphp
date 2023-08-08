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

        $this->writeInt($this->maxFriends);
        $this->writeInt(1337);
        $this->writeInt($this->maxFriendsHc);
        $this->writeInt(0);
    }
}