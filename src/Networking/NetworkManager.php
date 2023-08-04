<?php

namespace Emulator\Networking;

use Emulator\Main;
use React\EventLoop\Loop;
use Emulator\Utils\Logger;
use React\Socket\TcpServer;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use Emulator\Api\Networking\INetworkManager;
use Emulator\Networking\Packages\PackageManager;
use Emulator\Api\Networking\Packages\IPackageManager;
use Emulator\Networking\Connections\ConnectionManager;
use Emulator\Api\Networking\Connections\IConnectionManager;

class NetworkManager implements INetworkManager
{
    private readonly Logger $logger;

    private TcpServer $tcpServer;
    private LoopInterface $loop;

    private readonly IPackageManager $packageManager;
    private readonly IConnectionManager $connectionManager;

    public function __construct() {
        $this->logger = new Logger(get_class($this));

        $this->packageManager = new PackageManager();
        $this->connectionManager = new ConnectionManager();
    }
    
    public function initialize(): void
    {
        $this->logger->info('NetworkManager initialized!');

        $this->initializeServer();
    }

    private function initializeServer(): void
    {
        $host = Main::getEmulator()->getConfigManager()->get('server.host');
        $port = Main::getEmulator()->getConfigManager()->get('server.port');

        $this->loop = Loop::get();
        $this->tcpServer = new TcpServer("{$host}:{$port}", $this->loop);

        $this->tcpServer->on('connection', function (ConnectionInterface $connection) {
            $client = $this->connectionManager->addIfAbsent($connection);

            $this->logger->info(sprintf('[%s] connected. Total of connections: [%s]', $client->getId(), count($this->connectionManager->getClients())));

            $connection->on('data', function ($data) use (&$client) {
                $this->packageManager->handle($data, $client);
            });

            $connection->on('close', function () use ($connection) {
                $this->connectionManager->disposeClient($connection);
            });
        });

        $this->logger->info("Server listening on {$host}:{$port}!");
    }
}