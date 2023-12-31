<?php

namespace Emulator\Networking\Incoming\HotelView;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\HotelView\BonusRareComposer;

class HotelViewRequestBonusRareEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new BonusRareComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}