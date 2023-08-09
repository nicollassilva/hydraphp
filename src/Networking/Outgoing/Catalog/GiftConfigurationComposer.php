<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class GiftConfigurationComposer extends MessageComposer
{
    private array $boxTypes = [0, 1, 2, 3, 4, 5, 6, 8];
    private array $ribbonTypes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

    public function __construct()
    {
        $this->header = OutgoingHeaders::$giftConfigurationComposer;

        $this->writeBoolean(true);
        $this->writeInt(2);
        $this->writeInt(0);

        $this->writeInt(count($this->boxTypes));

        foreach ($this->boxTypes as $boxType) {
            $this->writeInt($boxType);
        }

        $this->writeInt(count($this->ribbonTypes));

        foreach ($this->ribbonTypes as $ribbonType) {
            $this->writeInt($ribbonType);
        }

        $this->writeInt(0);
    }
}