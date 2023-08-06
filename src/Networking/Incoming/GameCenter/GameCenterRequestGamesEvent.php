<?php

namespace Emulator\Networking\Incoming\GameCenter;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\GameCenter\GameCenterAchievementsConfigurationComposer;

class GameCenterRequestGamesEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new GameCenterAchievementsConfigurationComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}