<?php

namespace Emulator\Networking\Incoming\HotelView;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;

class HotelViewEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        if(!$client->getUser()?->getEntity()?->getRoom()) return;

        $client->getUser()
            ->getEntity()
            ->leaveRoom(false, true);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}