<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\RoomOpenComposer;

class JoinRoomEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        // $client->send(new RoomOpenComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}