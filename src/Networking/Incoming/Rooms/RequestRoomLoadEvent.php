<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Game\Rooms\RoomManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Game\Users\UserManager;
use Emulator\Networking\Outgoing\Rooms\{RoomOpenComposer,RoomModelComposer,RoomScoreComposer,HideDoorbellComposer, RoomPaintComposer, RoomPromotionComposer, RoomUsersComposer, RoomUserStatusComposer};

class RequestRoomLoadEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $roomId = $message->readInt32();
        $password = $message->readString();

        RoomManager::getInstance()->enterRoom($client->getUser(), $roomId, $password);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}