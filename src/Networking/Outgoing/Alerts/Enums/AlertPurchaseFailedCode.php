<?php

namespace Emulator\Networking\Outgoing\Alerts\Enums;

enum AlertPurchaseFailedCode: int
{
    case SERVER_ERROR = 0;
    case ALREADY_HAVE_BADGE = 1;
    case UNKNOWN = 2;
}