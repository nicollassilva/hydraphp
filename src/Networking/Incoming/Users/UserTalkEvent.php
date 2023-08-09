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

        if($userMessage == 'cpu') {
            $client->send(new UserTalkComposer($client->getUser()->getEntity(), 'CPU: ' . round(memory_get_usage() / 1024 / 1024, 2) . 'MB', $bubbleId));
            return;
        }

        if($userMessage == 'memory') {
            $client->send(new UserTalkComposer($client->getUser()->getEntity(), 'Memory: ' . round(memory_get_peak_usage() / 1024 / 1024, 2) . 'MB', $bubbleId));
            return;
        }

        if($userMessage == 'gc') {
            $number = gc_collect_cycles();
            $client->send(new UserTalkComposer($client->getUser()->getEntity(), 'PHP GC collected ' . $number . ' memory cycles.', $bubbleId));
            return;
        }

        $client->getUser()
            ->getEntity()
            ->getRoom()
            ->sendForAll(new UserTalkComposer($client->getUser()->getEntity(), $userMessage, $bubbleId));
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}