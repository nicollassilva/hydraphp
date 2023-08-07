<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\User\ModToolSanctionInfoComposer;

class RequestUserGroupBadgesEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new ModToolSanctionInfoComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}