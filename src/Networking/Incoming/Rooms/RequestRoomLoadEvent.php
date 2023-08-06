<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Game\Rooms\RoomManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\{RoomOpenComposer,RoomModelComposer,RoomScoreComposer,HideDoorbellComposer, RoomPaintComposer, RoomPromotionComposer, RoomUsersComposer, RoomUserStatusComposer};

class RequestRoomLoadEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $roomId = $message->readInt32();
        $password = $message->readString();

        $room = RoomManager::getInstance()->loadRoom(50);
        
        $client->send(new HideDoorbellComposer($client->getUser()->getData()->getUsername()))
            ->send(new RoomOpenComposer)
            ->send(new RoomUsersComposer($client->getUser()))
            ->send(new RoomUserStatusComposer)
            ->send(new RoomModelComposer($room))
            ->send(new RoomPaintComposer($room))
            ->send(new RoomScoreComposer($room))
            ->send(new RoomPromotionComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}