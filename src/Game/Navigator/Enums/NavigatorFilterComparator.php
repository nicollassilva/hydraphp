<?php

namespace Emulator\Game\Navigator\Enums;

enum NavigatorFilterComparator: string
{
    case Equals = "equals";
    case EqualsIgnoreCase = "equals_ignore_case";
    case Contains = "contains";
}