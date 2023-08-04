<?php

namespace Emulator\Networking\Outgoing\GameCenter;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class GameCenterAchievementsConfigurationComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$gameCenterAchievementsConfigurationComposer;

        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(3);
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeString("BaseJumpBigParachute");
        $this->writeInt32(1);
    }
}