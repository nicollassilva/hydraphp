<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Game\Rooms\Utils\ChatEmotion;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;
use Emulator\Game\Rooms\Types\Entities\UserEntity;

class UserTalkComposer extends MessageComposer
{
    public function __construct(UserEntity $entity, string $message, int $bubbleId)
    {
        $this->header = OutgoingHeaders::$userTalkComposer;

        $this->writeInt32($entity->getId());
        $this->writeString($message);
        $this->writeInt32(ChatEmotion::getByMessage($message)->value);
        $this->writeInt32($bubbleId);
        $this->writeInt32(0);
        $this->writeInt32(strlen($message));
    }
}