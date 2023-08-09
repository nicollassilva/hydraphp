<?php

namespace Emulator\Game\Rooms\Enums;

enum RoomEntityStatus: string
{
    case FlatCtrl = "flatctrl";
    case Move = "mv";
    case Gesture = "gst";
    case Sit = "sit";
    case Lay = "lay";
}