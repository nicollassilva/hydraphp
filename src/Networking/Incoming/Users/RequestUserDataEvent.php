<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\User\UserDataComposer;
use Emulator\Networking\Outgoing\User\UserPerksComposer;
use Emulator\Networking\Outgoing\User\MeMenuSettingsComposer;

class RequestUserDataEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $client->send(new UserDataComposer)
            ->send(new UserPerksComposer)
            ->send(new MeMenuSettingsComposer);
    }
}