<?php

namespace Emulator\Game\Rooms\Enums;

enum RoomTileState
{
    case Open;
    case Blocked;
    case Invalid;
    case Sit;
    case Lay;
}