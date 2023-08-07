<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\UserTypingComposer;

class UserStopTypingEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $userEntity = $client->getUser()->getEntity();

        if(!$userEntity || !$userEntity->getRoom()) return;

        $userEntity->getRoom()->sendForAll(new UserTypingComposer($userEntity, false));
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}