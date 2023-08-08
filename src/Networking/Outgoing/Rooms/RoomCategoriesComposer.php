<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomCategoriesComposer extends MessageComposer
{
    private array $categories = [
        1 => '${navigator.flatcategory.global.BC}',
        '${navigator.flatcategory.global.BUILDING}',
        '${navigator.flatcategory.global.CHAT}',
        '${navigator.flatcategory.global.FANSITE}',
        '${navigator.flatcategory.global.GAMES}',
        '${navigator.flatcategory.global.HELP}',
        '${navigator.flatcategory.global.LIFE}',
        '${navigator.flatcategory.global.OFFICIAL}',
        '${navigator.flatcategory.global.PARTY}',
    ];

    public function __construct()
    {
        $this->header = OutgoingHeaders::$roomCategoriesComposer;

        $this->writeInt(count($this->categories));

        foreach($this->categories as $key => $category) {
            $this->writeInt($key);
            $this->writeString($category);
            $this->writeBoolean(true);
            $this->writeBoolean(false);
            $this->writeString($category);
            $this->writeString("");
            $this->writeBoolean(false);
        }
    }
}