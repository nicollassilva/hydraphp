<?php

namespace Emulator\Networking\Outgoing\GameCenter;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class GameCenterGameListComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$gameCenterGameListComposer;

        $this->writeInt32(2);

        $this->writeInt32(0);
        $this->writeString("snowwar");
        $this->writeString("93d4f3");
        $this->writeString("");
        $this->writeString("https://swfs.hablush.com/c_images/gamecenter_snowwar/");
        $this->writeString("");

        $this->writeInt32(3);
        $this->writeString("basejump");
        $this->writeString("68bbd2");
        $this->writeString("");
        $this->writeString("https://swfs.hablush.com/c_images/gamecenter_snowwar/");
        $this->writeString("");
    }
}