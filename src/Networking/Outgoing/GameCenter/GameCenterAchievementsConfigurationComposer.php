<?php

namespace Emulator\Networking\Outgoing\GameCenter;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class GameCenterAchievementsConfigurationComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$gameCenterAchievementsConfigurationComposer;

        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(0);
        $this->writeInt(3);
        $this->writeInt(1);
        $this->writeInt(1);
        $this->writeString("BaseJumpBigParachute");
        $this->writeInt(1);
    }
}