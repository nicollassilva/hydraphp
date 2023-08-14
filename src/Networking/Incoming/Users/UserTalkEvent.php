<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\UserTalkComposer;

class UserTalkEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $userMessage = $message->readString();
        $bubbleId = $message->readInt();

        if($userMessage == ':memory') {
            $memory = round(memory_get_usage() / 1024 / 1024, 2);
            $peakMemory = round(memory_get_peak_usage() / 1024 / 1024, 2);

            $client->send(new UserTalkComposer($client->getUser()->getEntity(), "[PHP] Memory status: {$memory}MB with {$peakMemory}MB peak", $bubbleId));
            return;
        }

        if($userMessage == ':gc') {
            $number = gc_collect_cycles();
            $client->send(new UserTalkComposer($client->getUser()->getEntity(), '[PHP Garbage Collector] Collected ' . $number . ' memory cycles.', $bubbleId));
            return;
        }

        $client->getUser()
            ->getEntity()
            ->getRoom()
            ->broadcastMessage(new UserTalkComposer($client->getUser()->getEntity(), $userMessage, $bubbleId));
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}