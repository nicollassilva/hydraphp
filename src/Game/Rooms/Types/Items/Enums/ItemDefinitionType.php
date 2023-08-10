<?php

namespace Emulator\Game\Rooms\Types\Items\Enums;

enum ItemDefinitionType: string
{
    case Floor = 's';
    case Wall = 'i';
    case Effect = 'e';
    case Badge = 'b';
    case Robot = 'r';
    case Pet = 'p';
    case HabboClub = 'h';
}