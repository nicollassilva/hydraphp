<?php

namespace Emulator\Networking\Outgoing\GameCenter;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class GameCenterAccountInfoComposer extends MessageComposer
{
    public function __construct(int $gameId, int $gamesLeft)
    {
        $this->header = OutgoingHeaders::$gameCenterAccountInfoComposer;

        $this->writeInt32($gameId);
        $this->writeInt32($gamesLeft);
    }
}