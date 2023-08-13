<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class GenericErrorComposer extends MessageComposer
{
    public const AUTHENTICATION_FAILED = -3;
    public const CONNECTING_TO_THE_SERVER_FAILED = -400;
    public const KICKED_OUT_OF_THE_ROOM = 4008;
    public const NEED_TO_BE_VIP = 4009;
    public const ROOM_NAME_UNACCEPTABLE = 4010;
    public const CANNOT_BAN_GROUP_MEMBER = 4011;
    public const WRONG_PASSWORD_USED = -100002;

    public function __construct(string $username)
    {
        $this->header = OutgoingHeaders::$genericErrorComposer;

        $this->writeString($username);
    }
}