<?php

namespace Emulator\Game\Rooms\Enums;

enum RoomRightLevels: string
{
    case None = "0";
    case Rights = "1";
    case GroupRights = "2";
    case GroupAdmin = "3";
    case Owner = "4";
    case Moderator = "5";
    case Six = "6";
    case Seven = "7";
    case Eight = "8";
    case Nine = "9";
}