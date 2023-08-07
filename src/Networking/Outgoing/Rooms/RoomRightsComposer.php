<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Game\Rooms\Enums\RoomRightLevels;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomRightsComposer extends MessageComposer
{
    public function __construct(RoomRightLevels &$status)
    {
        $this->header = OutgoingHeaders::$roomRightsComposer;

        $this->writeInt32((int) $status->value);
    }
}