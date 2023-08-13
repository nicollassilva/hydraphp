<?php

namespace Emulator\Api\Game\Utilities\Handlers;

use Emulator\Utils\Logger;
use Emulator\Game\Utilities\Handlers\Enums\HandleTypeProcess;

interface IAbstractHandler
{
    public static function dispatch(...$params): IAbstractHandler;
    
    public function handle(HandleTypeProcess $handleTypeProcess, ...$params): void;
    public function getLogger(): Logger;
}