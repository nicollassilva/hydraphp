<?php

namespace Emulator\Game\Navigator\Enums;

enum NavigatorListMode: int
{
    case List = 0;
    case Thumbnails = 1;
    case ForcedThumbnails = 2;
}