<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Rooms\Handlers\JoinRoomHandler;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Game\Utilities\Handlers\Enums\HandleTypeProcess;

class RequestRoomLoadEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        JoinRoomHandler::dispatch(
            HandleTypeProcess::FirstProcess,
            $client->getUser(), $message->readInt(), $message->readString()
        );
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}