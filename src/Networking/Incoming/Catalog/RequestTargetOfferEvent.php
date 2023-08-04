<?php

namespace Emulator\Networking\Incoming\Catalog;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Catalog\TargetedOfferComposer;

class RequestTargetOfferEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        // $client->send(new TargetedOfferComposer);
    }
}