<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class FavoriteRoomsCountComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$favoriteRoomsCountComposer;

        $this->writeInt(30);
        $this->writeInt(0);
    }
}