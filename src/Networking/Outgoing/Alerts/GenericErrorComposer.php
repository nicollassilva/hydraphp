<?php

namespace Emulator\Networking\Outgoing\Alerts;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;
use Emulator\Networking\Outgoing\Alerts\Enums\GenericErrorCode;

class GenericErrorComposer extends MessageComposer
{
    public function __construct(GenericErrorCode $errorCode)
    {
        $this->header = OutgoingHeaders::$genericErrorComposer;

        $this->writeInt($errorCode->value);
    }
}