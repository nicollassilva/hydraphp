<?php

namespace Emulator\Networking\Incoming\Catalog;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Catalog\CatalogModeComposer;
use Emulator\Networking\Outgoing\Catalog\CatalogPagesListComposer;

class RequestCatalogModeEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $mode = $message->readString();

        $client->send(new CatalogModeComposer($mode == 'normal' ? 0 : 1))
            ->send(new CatalogPagesListComposer($client->getUser(), $mode));
    }

    public function needsAuthentication(): bool
    {
        return true;
    }
}