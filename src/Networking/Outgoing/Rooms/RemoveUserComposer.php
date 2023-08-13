<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RemoveUserComposer extends MessageComposer
{
    public function __construct(int $entityId)
    {
        $this->header = OutgoingHeaders::$removeUserComposer;

        $this->writeString("{$entityId}");
    }
}