<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\RoomHeightmapComposer;
use Emulator\Networking\Outgoing\Rooms\{RoomModelComposer, RoomRelativeMapComposer,RoomOpenComposer};

class JoinRoomEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        if(!$client->getUser()->getEntity() || !$client->getUser()->getEntity()->getRoom()) return;

        $room = $client->getUser()->getEntity()->getRoom();

        $client->send(new RoomOpenComposer)
            ->send(new RoomModelComposer($room))
            ->send(new RoomRelativeMapComposer($room))
            ->send(new RoomHeightmapComposer($room));
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}