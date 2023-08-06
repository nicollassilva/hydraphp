<?php

namespace Emulator\Networking\Incoming\GameCenter;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\GameCenter\GameCenterGameListComposer;

class GetGameListMessageEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new GameCenterGameListComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}