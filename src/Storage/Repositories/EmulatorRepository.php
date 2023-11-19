<?php

namespace Emulator\Storage\Repositories;

use Closure;
use Throwable;
use Emulator\Hydra;
use Amp\Mysql\MysqlResult;
use Emulator\Utils\Logger;
use Amp\Mysql\MysqlConnectionPool;
use Emulator\Storage\ConnectorManager;

use function Amp\async;
use function Amp\Future\await;

interface IEmulatorRepository
{
    public static function getLogger(): Logger;
}

abstract class EmulatorRepository implements IEmulatorRepository
{
    public static function getConnection(): MysqlConnectionPool
    {
        return ConnectorManager::getInstance()->getConnection();
    }

    public static function loadEmulatorConfigurations(): array
    {
        $configurations = [];

        self::databaseQuery('SELECT * FROM emulator_settings', function(MysqlResult $result) use (&$configurations) {
            if(empty($result)) return;

            foreach($result as $row) {
                $configurations[$row['key']] = $row['value'];
            }
        });

        return $configurations;
    }

    public static function databaseQuery(string $select, Closure $onSuccessCallback, array $params = [], ?Closure $onErrorCallback = null): void
    {
        if(is_null($onErrorCallback)) {
            $onErrorCallback = function(Throwable $error) {
                if(!Hydra::$isDebugging) return;
                
                self::getLogger()->error($error->getMessage());
            };
        }

        $statement = null;

        try {
            $statement = self::getConnection()->prepare($select);
            
            $result = async(fn () => $statement->execute($params));
        } catch (\Throwable $error) {
            $onErrorCallback($error);
            return;
        }

        [$result] = await([$result]);

        $onSuccessCallback($result);
    }
}
