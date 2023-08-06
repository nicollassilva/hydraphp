<?php

namespace Emulator\Networking\Incoming\Navigator;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Navigator\{
    NewNavigatorMetaDataComposer,
    NewNavigatorSettingsComposer,
    NewNavigatorLiftedRoomsComposer,
    NewNavigatorSavedSearchesComposer,
    NewNavigatorEventCategoriesComposer,
    NewNavigatorCollapsedCategoriesComposer
};

class RequestNewNavigatorDataEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new NewNavigatorSettingsComposer)
            ->send(new NewNavigatorMetaDataComposer)
            ->send(new NewNavigatorLiftedRoomsComposer)
            ->send(new NewNavigatorCollapsedCategoriesComposer)
            ->send(new NewNavigatorSavedSearchesComposer)
            ->send(new NewNavigatorEventCategoriesComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}