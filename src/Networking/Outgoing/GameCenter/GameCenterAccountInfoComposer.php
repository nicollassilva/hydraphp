<?php

namespace Emulator\Networking\Outgoing\GameCenter;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class GameCenterAccountInfoComposer extends MessageComposer
{
    public function __construct(int $gameId, int $gamesLeft)
    {
        $this->header = OutgoingHeaders::$gameCenterAccountInfoComposer;

        $this->writeInt($gameId);
        $this->writeInt($gamesLeft);
    }
}