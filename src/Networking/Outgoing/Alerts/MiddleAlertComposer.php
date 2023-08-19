<?php

namespace Emulator\Networking\Outgoing\Alerts;

use Emulator\Game\Utilities\Enums\MiddleAlertKeyTypes;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class MiddleAlertComposer extends MessageComposer
{
    public function __construct(MiddleAlertKeyTypes $errorKey, string $message)
    {
        $this->header = OutgoingHeaders::$middleAlertComposer;

        $this->writeString($errorKey->value);

        $this->writeInt(1);
        
        $this->writeString('message');
        $this->writeString($message);
    }
}