<?php

namespace Emulator\Networking\Outgoing\Alerts\Enums;

enum AlertPurchaseUnavailableCode: int
{
    case ILLEGAL_PURCHASE = 0;
    case REQUIRES_CLUB = 1;
}