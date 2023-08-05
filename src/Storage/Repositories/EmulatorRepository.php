<?php

namespace Emulator\Storage\Repositories;

use Closure;
use Throwable;
use Emulator\Hydra;
use function React\Async\await;
use React\MySQL\ConnectionInterface;

abstract class EmulatorRepository
{
    public static function getConnection(): ConnectionInterface
    {
        return Hydra::getEmulator()->getConnectorManager()->getConnection();
    }

    public static function encapsuledSelect(string $select, Closure $onSuccessCallback, array $params = [], ?Closure $onErrorCallback = null): void
    {
        $connection = self::getConnection();

        if(!is_callable($onErrorCallback)) {
            $onErrorCallback = function(Throwable $error) {
                self::getLogger()->error($error->getMessage());
            };
        }

        $result = await($connection->query($select, $params));

        if($result instanceof \Throwable) {
            $onErrorCallback($result);
            return;
        }

        $onSuccessCallback($result);

        $connection->quit();
        unset($connection);
    }
}
