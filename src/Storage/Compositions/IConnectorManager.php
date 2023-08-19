<?php

namespace Emulator\Storage\Compositions;

use Emulator\Utils\Logger;
use Amp\Mysql\MysqlConnectionPool;

interface IConnectorManager
{
    public function getConnection(): MysqlConnectionPool;
    public function getLogger(): Logger;
    public function initialize(): void;
}