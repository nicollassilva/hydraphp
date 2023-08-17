<?php

namespace Emulator\Networking\Incoming\Items;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;

class ToggleFloorItemEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        if(!$room = $client->getUser()->getEntity()->getRoom()) return;

        $itemId = $message->readInt();
        $state = $message->readInt();

        if(!$item = $room->getItemComponent()->getFloorItemByVirtualId($itemId)) return;

        $item->onInteract($client->getUser()->getEntity(), $state);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}