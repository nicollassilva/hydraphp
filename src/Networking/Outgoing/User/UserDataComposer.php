<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Api\Game\Users\IUser;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserDataComposer extends MessageComposer
{
    public function __construct(IUser $user)
    {
        $this->header = OutgoingHeaders::$userDataComposer;

        $this->writeInt($user->getData()->getId());
        $this->writeString($user->getData()->getUsername());
        $this->writeString($user->getData()->getLook());
        $this->writeString($user->getData()->getGender());
        $this->writeString($user->getData()->getMotto());
        $this->writeString($user->getData()->getUsername());
        $this->writeBoolean(false);
        $this->writeInt($user->getSettings()->getRespectPointsReceived());
        $this->writeInt($user->getSettings()->getRespectPointsGiven());
        $this->writeInt($user->getSettings()->getPetRespectPointsToGive());
        $this->writeBoolean(false);
        $this->writeString("01-01-1970 00:00:00");
        $this->writeString($user->getSettings()->getAllowNameChange());
        $this->writeString(false);
    }
}