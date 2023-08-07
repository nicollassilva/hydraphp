<?php

namespace Emulator\Networking\Incoming\Emulator;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;

class PongEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        // $client->getLogger()->info('Pong!');
    }

    
    public function needsAuthentication(): bool
    {
        return false;
    }
}