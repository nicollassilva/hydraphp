<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomCreatedComposer extends MessageComposer
{
    public function __construct(int $roomId, string $roomName)
    {
        $this->header = OutgoingHeaders::$roomCreatedComposer;

        $this->writeInt($roomId);
        $this->writeString($roomName);
    }
}