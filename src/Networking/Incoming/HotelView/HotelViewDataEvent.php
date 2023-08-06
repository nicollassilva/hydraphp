<?php

namespace Emulator\Networking\Incoming\HotelView;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\HotelView\HotelViewDataComposer;

class HotelViewDataEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $data = $message->readString();
        $splittedData = str_contains($data, ';') ? explode(';', $data) : explode(',', $data);

        if(!str_contains($data, ';')) {
            $client->send(new HotelViewDataComposer($data, $splittedData[count($splittedData) - 1]));
            return;
        }

        foreach ($splittedData as $completeKey) {
            if(!str_contains($completeKey, ',')) {
                $client->send(new HotelViewDataComposer($data, $completeKey));
                continue;
            }

            $splittedCompleteKey = explode(',', $completeKey);

            $client->send(new HotelViewDataComposer($completeKey, $splittedCompleteKey[count($splittedCompleteKey) - 1]));
        }
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}