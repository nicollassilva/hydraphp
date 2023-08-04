<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\HideDoorbellComposer;
use Emulator\Networking\Outgoing\Rooms\PrivateRoomsComposer;
use Emulator\Networking\Outgoing\Rooms\RoomDataComposer;
use Emulator\Networking\Outgoing\Rooms\RoomModelComposer;
use Emulator\Networking\Outgoing\Rooms\RoomOpenComposer;
use Emulator\Networking\Outgoing\Rooms\RoomPromotionComposer;
use Emulator\Networking\Outgoing\Rooms\RoomScoreComposer;

class RequestRoomLoadEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $roomId = $message->readInt32();
        $password = $message->readString();
        
        $client->send(new HideDoorbellComposer(""))
            ->send(new RoomOpenComposer)
            ->send(new RoomModelComposer)
            ->send(new RoomScoreComposer)
            ->send(new RoomPromotionComposer);
    }
}