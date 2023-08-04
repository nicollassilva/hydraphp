<?php

namespace Emulator\Networking\Incoming\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;

class UserActivityEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $type = $message->readString();
        $value = $message->readString();
        $action = $message->readString();

        if($type == 'Quiz' && $value == '7') {
            // progress action
        }

        $validActions = [
            'forum.can.read.seen' => 'SelfModForumCanReadSeen',
            'forum.can.post.seen' => 'SelfModForumCanPostSeen',
            'forum.can.start.thread.seen' => 'SelfModForumCanPostThrdSeen',
            'forum.can.moderate.seen' => 'SelfModForumCanModerateSeen',
            'room.settings.doormode.seen' => 'SelfModDoorModeSeen',
            'room.settings.walkthrough.seen' => 'SelfModWalkthroughSeen',
            'room.settings.chat.scrollspeed.seen' => 'SelfModChatScrollSpeedSeen',
            'room.settings.chat.hearrange.seen' => 'SelfModChatHearRangeSeen',
            'room.settings.chat.floodfilter.seen' => 'SelfModChatFloodFilterSeen'
        ];

        if(isset($validActions[$action])) {
            // progress action
        }
    }
}