<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\UserTalkComposer;

class UserTalkEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $userMessage = $message->readString();
        $bubbleId = $message->readInt32();

        $client->getUser()
            ->getEntity()
            ->getRoom()
            ->sendForAll(new UserTalkComposer($client->getUser()->getEntity(), $userMessage, $bubbleId));
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}