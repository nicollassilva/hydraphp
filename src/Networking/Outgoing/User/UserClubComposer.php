<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserClubComposer extends MessageComposer
{
    public function __construct(string $subscriptionType = 'habbo_club')
    {
        $this->header = OutgoingHeaders::$userClubComposer;
        
        $this->writeString(strtolower($subscriptionType));
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeBoolean(false);
        $this->writeBoolean(false);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
        $this->writeInt32(0);
    }
}