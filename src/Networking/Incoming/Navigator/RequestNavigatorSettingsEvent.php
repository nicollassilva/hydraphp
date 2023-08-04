<?php

namespace Emulator\Networking\Incoming\Navigator;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Navigator\NewNavigatorSettingsComposer;

class RequestNavigatorSettingsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new NewNavigatorSettingsComposer);
    }
}