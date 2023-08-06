<?php

namespace Emulator\Api\Networking\Incoming;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;

interface IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void;
    public function needsAuthentication(): bool;
}