<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\User\ModToolSanctionInfoComposer;

class UsernameEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        // TODO: Implement this
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}