<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Game\Rooms\RoomManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;

class RequestRoomLoadEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $roomId = $message->readInt();
        $password = $message->readString();

        RoomManager::getInstance()->sendInitialRoomData($client->getUser(), $roomId, $password);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}