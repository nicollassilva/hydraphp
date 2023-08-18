<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class CanCreateRoomComposer extends MessageComposer
{
    public function __construct(int $userRoomsCount, int $maximumRoomsAllowed)
    {
        $this->header = OutgoingHeaders::$canCreateRoomComposer;

        $this->writeInt((int) $userRoomsCount >= $maximumRoomsAllowed);
        $this->writeInt($maximumRoomsAllowed);
    }
}