<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\User\MeMenuSettingsComposer;

class RequestMeMenuSettingsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new MeMenuSettingsComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}