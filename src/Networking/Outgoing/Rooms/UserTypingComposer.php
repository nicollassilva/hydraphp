<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserTypingComposer extends MessageComposer
{
    public function __construct(UserEntity &$userEntity, bool $isTyping)
    {
        $this->header = OutgoingHeaders::$userTypingComposer;

        $this->writeInt($userEntity->getVirtualId());
        $this->writeInt((int) $isTyping);
    }
}