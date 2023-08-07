<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Users\IUser;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomUsersComposer extends MessageComposer
{
    public function __construct(?IUser $user = null)
    {
        $this->header = OutgoingHeaders::$roomUsersComposer;

        $this->writeInt32(1);
        $this->writeInt32($user->getData()->getId());
        $this->writeString($user->getData()->getUsername());
        $this->writeString($user->getData()->getMotto());
        $this->writeString($user->getData()->getLook());
        $this->writeInt32($user->getEntity()->getId());
        $this->writeInt32($user->getEntity()->getPosition()->getX());
        $this->writeInt32($user->getEntity()->getPosition()->getY());
        $this->writeString((string) $user->getEntity()->getPosition()->getZ());
        $this->writeInt32($user->getEntity()->getBodyRotation());
        $this->writeInt32(1);
        $this->writeString($user->getData()->getGender());
        $this->writeInt32(-1);
        $this->writeInt32(-1);
        $this->writeString('');
        $this->writeString('');
        $this->writeInt32($user->getSettings()->getAchievementScore());
        $this->writeBoolean(true);
    }
}