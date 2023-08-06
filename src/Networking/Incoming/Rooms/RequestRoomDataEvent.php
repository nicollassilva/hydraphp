<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\PrivateRoomsComposer;
use Emulator\Networking\Outgoing\Rooms\RoomDataComposer;

class RequestRoomDataEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $unknowParam1 = $message->readInt32();
        $unknowParam2 = $message->readInt32();

        $client->send(new RoomDataComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}