<?php

namespace Emulator\Networking\Incoming\Emulator;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Emulator\PongComposer;

class PingEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new PongComposer($message->readInt32()));
    }
}