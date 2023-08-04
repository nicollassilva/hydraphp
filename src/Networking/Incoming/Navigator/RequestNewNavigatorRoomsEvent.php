<?php

namespace Emulator\Networking\Incoming\Navigator;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\NewNavigatorSearchResultsComposer;

class RequestNewNavigatorRoomsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $category = $message->readString();
        $search = $message->readString();

        if (in_array($category, ['query', 'groups'])) {
            $category = "hotel_view";
        }

        $client->send(new NewNavigatorSearchResultsComposer($category, $search));
    }
}