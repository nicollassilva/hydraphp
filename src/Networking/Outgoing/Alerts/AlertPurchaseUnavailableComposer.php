<?php

namespace Emulator\Networking\Outgoing\Alerts;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;
use Emulator\Networking\Outgoing\Alerts\Enums\AlertPurchaseUnavailableCode;

class AlertPurchaseUnavailableComposer extends MessageComposer
{
    public function __construct(AlertPurchaseUnavailableCode $errorCode)
    {
        $this->header = OutgoingHeaders::$alertPurchaseUnavailableComposer;

        $this->writeInt($errorCode->value);
    }
}