<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\User\UserClubComposer;

class RequestUserClubEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $subscriptionType = $message->readString();

        $client->send(new UserClubComposer($subscriptionType));
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}