<?php

namespace Emulator\Networking\Outgoing\HotelView;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class BonusRareComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$bonusRareComposer;

        $this->writeString("prizetrophy_breed_gold");
        $this->writeInt(0);
        $this->writeInt(120);
        $this->writeInt(0);
    }
}