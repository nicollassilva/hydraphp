<?php

namespace Emulator\Api\Game\Utilities;

use Emulator\Api\Networking\Outgoing\IMessageComposer;

interface IComposable
{
    public function compose(IMessageComposer $message): void;
}