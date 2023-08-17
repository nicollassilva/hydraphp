<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomPaintComposer extends MessageComposer
{
    public function __construct(string $type, string $value)
    {
        $this->header = OutgoingHeaders::$roomPaintComposer;

        $this->writeString($type);
        $this->writeString($value);
    }
}