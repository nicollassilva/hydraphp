<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;

class UserLookToEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        if(!$entity = $client->getUser()->getEntity()) return;

        if(!$entity->getRoom() || $entity->isWalking()) return;

        $x = $message->readInt();
        $y = $message->readInt();

        if($entity->getPosition()->getX() == $x && $entity->getPosition()->getY() == $y) return;

        $entity->lookToPoint($x, $y, true);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}