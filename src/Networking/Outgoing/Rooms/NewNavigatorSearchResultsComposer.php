<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class NewNavigatorSearchResultsComposer extends MessageComposer
{
    public function __construct(string $category, string $search)
    {
        $this->header = OutgoingHeaders::$newNavigatorSearchResultsComposer;

        $this->writeString($category);
        $this->writeString($search);
        $this->writeInt32(1);

        $this->writeString($category);
        $this->writeString($search);
        $this->writeInt32(0);
        $this->writeBoolean(true);
        $this->writeInt32(0);

        $this->writeInt32(1);

        $this->writeInt32(1);
        $this->writeString('PHP Emulator');
        $this->writeInt32(1);
        $this->writeString('iNicollas');
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(20);
        $this->writeString("Emulator made with PHP");
        $this->writeInt32(0);
        $this->writeInt32(1);
        $this->writeInt32(0);
        $this->writeInt32(1);
        $this->writeInt32(0);
        $this->writeInt32(0);
    }
}