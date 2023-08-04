<?php

namespace Emulator\Networking\Incoming\Messenger;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Messenger\MessengerInitComposer;

class RequestInitFriendsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new MessengerInitComposer);
    }
}