<?php

namespace Emulator\Game\Utilities\Handlers;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Utilities\Handlers\IAbstractHandler;

abstract class AbstractHandler implements IAbstractHandler
{
    private readonly Logger $logger;
    
    public function __construct(...$params)
    {
        $this->logger = new Logger(get_class($this));

        $this->handle(array_shift($params), ...$params);
    }
    
    public static function dispatch(...$params): IAbstractHandler
    {
        return new static(...$params);
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }
}