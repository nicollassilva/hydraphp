<?php

namespace Emulator\Networking\Outgoing\Alerts;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;
use Emulator\Networking\Outgoing\Alerts\Enums\AlertPurchaseFailedCode;

class AlertPurchaseFailedComposer extends MessageComposer
{
    public function __construct(AlertPurchaseFailedCode $errorCode)
    {
        $this->header = OutgoingHeaders::$alertPurchaseFailedComposer;

        $this->writeInt($errorCode->value);
    }
}