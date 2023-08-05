<?php

namespace Emulator\Storage;

use Closure;
use Exception;
use React\MySQL\Factory;
use Emulator\Utils\Logger;
use React\MySQL\ConnectionInterface;
use Emulator\Storage\Compositions\IConnectorManager;

class ConnectorManager implements IConnectorManager
{
    private readonly Logger $logger;
    private readonly ConnectionInterface $connection;

    public function __construct(
        private readonly string $host,
        private readonly int $port,
        private readonly string $user,
        private readonly string $password,
        private readonly string $dbName,
        private readonly string $tcpKeepAlive,
        private readonly string $autoReconnect,
        private readonly ?Closure $onConnectionCallback = null
    ) {
        $this->logger = new Logger(get_class($this));

        $this->initializeConnector();
    }

    private function initializeConnector(): void
    {
        $connectionFactory = new Factory();
        $connectionString = "{$this->user}:{$this->password}@{$this->host}:{$this->port}/{$this->dbName}?characterEncoding=utf8&useSSL=false";

        if($this->tcpKeepAlive) {
            $connectionString .= "&tcpKeepAlive={$this->tcpKeepAlive}";
        }

        if($this->autoReconnect) {
            $connectionString .= "&autoReconnect={$this->autoReconnect}";
        }

        $connectionFactory->createConnection($connectionString)
            ->then(
                fn (ConnectionInterface $connection) => $this->onConnectionSuccessfully($connection),
                fn (Exception $exception) => $this->onConnectionError($exception)
            );
    }

    private function onConnectionSuccessfully(ConnectionInterface $connection): void
    {
        $this->connection = $connection;

        $this->logger->success('Connected to database successfully.');

        if($this->onConnectionCallback) call_user_func($this->onConnectionCallback);
    }

    private function onConnectionError(Exception $exception): void
    {
        $this->logger->error($exception->getMessage());
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }
}