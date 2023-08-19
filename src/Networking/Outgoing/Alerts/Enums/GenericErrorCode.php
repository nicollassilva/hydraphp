<?php

namespace Emulator\Networking\Outgoing\Alerts\Enums;

enum GenericErrorCode: int
{
    case AUTHENTICATION_FAILED = -3;
    case CONNECTING_TO_THE_SERVER_FAILED = -400;
    case KICKED_OUT_OF_THE_ROOM = 4008;
    case NEED_TO_BE_VIP = 4009;
    case ROOM_NAME_UNACCEPTABLE = 4010;
    case CANNOT_BAN_GROUP_MEMBER = 4011;
    case WRONG_PASSWORD_USED = -100002;
}
