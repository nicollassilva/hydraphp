<?php

namespace Emulator\Networking\Incoming\Handshake;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Handshake\UniqueMachineIdComposer;
use Emulator\Utils\StringUtils;

class UniqueIdEvent implements IIncomingMessage
{
    private int $hashLength = 64;

    public function handle(IClient $client, ClientMessage $message): void
    {
        $storedMachineId = $message->readString();

        if(str_starts_with($storedMachineId, '~') || strlen($storedMachineId) < $this->hashLength) {
            $storedMachineId = StringUtils::getRandom($this->hashLength);

            $client->send(new UniqueMachineIdComposer($storedMachineId));
        }

        $client->setUniqueId($storedMachineId);
    }

    
    public function needsAuthentication(): bool
    {
        return false;
    }
}