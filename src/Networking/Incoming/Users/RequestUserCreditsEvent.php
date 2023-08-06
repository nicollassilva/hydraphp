<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\User\UserCreditsComposer;
use Emulator\Networking\Outgoing\User\UserCurrencyComposer;

class RequestUserCreditsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new UserCreditsComposer)
            ->send(new UserCurrencyComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}