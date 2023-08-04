<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class FavoriteRoomsCountComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$favoriteRoomsCountComposer;

        $this->writeInt32(30);
        $this->writeInt32(0);
    }
}