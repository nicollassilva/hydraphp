<?php

namespace Emulator\Networking\Incoming\Handshake;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;

class ReleaseVersionEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->setVersion($message->readString());
    }
    
    public function needsAuthentication(): bool
    {
        return false;
    }
}