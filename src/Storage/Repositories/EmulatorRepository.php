<?php

namespace Emulator\Storage\Repositories;

use Closure;
use Throwable;
use Emulator\Hydra;
use React\MySQL\QueryResult;
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

        $connection->query($select, $params)
            ->then(fn (QueryResult $result) => $onSuccessCallback($result))
            ->catch(fn (Throwable $error) => $onErrorCallback($error));

        $connection->quit();
        unset($connection);
    }
}
