<?php

namespace Emulator\Networking\Incoming\Inventory;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;

class RequestInventoryItemsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}