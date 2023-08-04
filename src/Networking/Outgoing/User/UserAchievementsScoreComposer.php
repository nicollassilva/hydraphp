<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserAchievementsScoreComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userAchievementsScoreComposer;

        $this->writeInt32(100);
    }
}