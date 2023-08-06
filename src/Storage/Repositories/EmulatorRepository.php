<?php

namespace Emulator\Storage\Repositories;

use Closure;
use Throwable;
use Emulator\Hydra;
use Emulator\Utils\Logger;
use function React\Async\await;
use React\MySQL\ConnectionInterface;

interface IEmulatorRepository
{
    public static function getLogger(): Logger;
}

abstract class EmulatorRepository implements IEmulatorRepository
{
    public static function getConnection(): ConnectionInterface
    {
        return Hydra::getEmulator()->getConnectorManager()->getConnection();
    }

    public static function encapsuledSelect(string $select, Closure $onSuccessCallback, array $params = [], ?Closure $onErrorCallback = null): void
    {
        if(!is_callable($onErrorCallback)) {
            $onErrorCallback = function(Throwable $error) {
                if(!Hydra::$isDebugging) return;
                
                self::getLogger()->error($error->getMessage());
            };
        }

        $result = await(self::getConnection()->query($select, $params));

        if($result instanceof \Throwable) {
            $onErrorCallback($result);
            return;
        }

        $onSuccessCallback($result);
    }
}
