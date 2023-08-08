<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\UserTalkComposer;

class UserWalkingEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $entity = $client->getUser()->getEntity();

        if(!$entity || !$entity->getRoom()) return;

        $posX = $message->readInt();
        $posY = $message->readInt();

        if($entity->getPosition()->getX() == $posX && $entity->getPosition()->getY() == $posY) return;

        $entity->moveTo($posX, $posY);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}