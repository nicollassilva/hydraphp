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

        $this->writeInt($entity->getId());
        $this->writeString($message);
        $this->writeInt(ChatEmotion::getByMessage($message)->value);
        $this->writeInt($bubbleId);
        $this->writeInt(0);
        $this->writeInt(strlen($message));
    }
}