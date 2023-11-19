<?php

namespace Emulator\Storage;

use Throwable;
use Emulator\Hydra;
use Amp\Mysql\MysqlConfig;
use Emulator\Utils\Logger;
use Amp\Mysql\MysqlConnectionPool;
use Emulator\Storage\Compositions\IConnectorManager;

class ConnectorManager implements IConnectorManager
{
    public static ?ConnectorManager $instance = null;

    private readonly Logger $logger;
    private readonly MysqlConnectionPool $connectionPool;

    public function __construct(
        private readonly string $host,
        private readonly int $port,
        private readonly string $user,
        private readonly string $password,
        private readonly string $dbName,
        private readonly string $tcpKeepAlive,
        private readonly string $autoReconnect
    ) {
        $this->logger = new Logger(get_class($this));
    }

    public static function getInstance(): ConnectorManager
    {
        if(!(self::$instance instanceof ConnectorManager)) {
            self::$instance = new ConnectorManager(
                Hydra::getEmulator()->getConfigManager()->get('hydra.db.host'),
                Hydra::getEmulator()->getConfigManager()->get('hydra.db.port'),
                Hydra::getEmulator()->getConfigManager()->get('hydra.db.user'),
                Hydra::getEmulator()->getConfigManager()->get('hydra.db.password'),
                Hydra::getEmulator()->getConfigManager()->get('hydra.db.name'),
                Hydra::getEmulator()->getConfigManager()->get('hydra.db.tcpKeepAlive'),
                Hydra::getEmulator()->getConfigManager()->get('hydra.db.autoReconnect')
            );
        }

        return self::$instance;
    }

    public function initialize(): void
    {
        $this->initializeConnector();
    }

    private function initializeConnector(): void
    {
        try {
            $connectionConfig = MysqlConfig::fromString(
                "host={$this->host};" .
                "port={$this->port};" .
                "user={$this->user};" .
                "password={$this->password};" .
                "dbname={$this->dbName};" .
                "tcpKeepAlive={$this->tcpKeepAlive};" .
                "autoReconnect={$this->autoReconnect}"
            );

            $this->connectionPool = new MysqlConnectionPool($connectionConfig);

            $this->logger->success('Connected to database successfully.');
        } catch (Throwable $error) {
            $this->onConnectionError($error);
        }
    }

    private function onConnectionError(Throwable $exception): void
    {
        $this->logger->error($exception->getMessage());
    }

    public function getConnection(): MysqlConnectionPool
    {
        return $this->connectionPool;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }
}