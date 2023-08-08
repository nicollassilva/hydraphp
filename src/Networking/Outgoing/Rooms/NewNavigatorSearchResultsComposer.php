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
        $this->writeInt(1);

        $this->writeString($category);
        $this->writeString($search);
        $this->writeInt(0);
        $this->writeBoolean(true);
        $this->writeInt(0);

        $this->writeInt(1);

        $this->writeInt(58);
        $this->writeString('PHP Emulator');
        $this->writeInt(1);
        $this->writeString('iNicollas');
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(20);
        $this->writeString("Emulator made with PHP");
        $this->writeInt(0);
        $this->writeInt(1);
        $this->writeInt(0);
        $this->writeInt(1);
        $this->writeInt(0);
        $this->writeInt(0);
    }
}