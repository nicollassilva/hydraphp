<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Users\IUser;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomUsersComposer extends MessageComposer
{
    public function __construct(IUser $user)
    {
        $this->header = OutgoingHeaders::$roomUsersComposer;

        $this->writeInt32(1);
        $this->writeInt32($user->getData()->getId());
        $this->writeString($user->getData()->getUsername());
        $this->writeString($user->getData()->getMotto());
        $this->writeString($user->getData()->getLook());
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeInt32(1);
        $this->writeString("");
        $this->writeInt32(2);
        $this->writeInt32(1);
        $this->writeString('M');
        $this->writeInt32(-1);
        $this->writeInt32(-1);
    }
}