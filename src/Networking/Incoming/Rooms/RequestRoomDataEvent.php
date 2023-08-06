<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Game\Rooms\RoomManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\RoomDataComposer;

class RequestRoomDataEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $roomId = $message->readInt32();

        $room = RoomManager::getInstance()->loadRoom(58);

        $something = $message->readInt32();
        $somethingTwo = $message->readInt32();

        if(empty($room)) return;

        $client->send(new RoomDataComposer($room, $client->getUser(), true, !($something == 0 && $somethingTwo == 1)));
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}