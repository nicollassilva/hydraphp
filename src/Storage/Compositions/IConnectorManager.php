<?php

namespace Emulator\Storage\Compositions;

use Emulator\Utils\Logger;
use React\MySQL\ConnectionInterface;

interface IConnectorManager
{
    public function getConnection(): ConnectionInterface;
    public function getLogger(): Logger;
}