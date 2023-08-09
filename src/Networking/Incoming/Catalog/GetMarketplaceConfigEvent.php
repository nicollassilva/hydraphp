<?php

namespace Emulator\Networking\Incoming\Catalog;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Catalog\Marketplace\MarketplaceConfigComposer;

class GetMarketplaceConfigEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new MarketplaceConfigComposer);
    }

    public function needsAuthentication(): bool
    {
        return true;
    }
}