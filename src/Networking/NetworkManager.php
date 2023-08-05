<?php

namespace Emulator\Networking;

use Throwable;
use Emulator\Hydra;
use React\EventLoop\Loop;
use Emulator\Utils\Logger;
use React\Socket\TcpServer;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use Emulator\Api\Networking\INetworkManager;
use Emulator\Networking\Packages\PackageManager;
use Emulator\Networking\Connections\ClientManager;
use Emulator\Api\Networking\Packages\IPackageManager;
use Emulator\Api\Networking\Connections\IClientManager;

class NetworkManager implements INetworkManager
{
    private readonly Logger $logger;

    private TcpServer $tcpServer;
    private LoopInterface $loop;

    private readonly IPackageManager $packageManager;
    private readonly IClientManager $clientManager;

    public function __construct() {
        $this->logger = new Logger(get_class($this));

        $this->packageManager = new PackageManager();
        $this->clientManager = new ClientManager();

        $this->initialize();
    }
    
    private function initialize(): void
    {
        try {
            $this->initializeServer();
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());
        }
    }

    private function initializeServer(): void
    {
        $host = Hydra::getEmulator()->getConfigManager()->get('server.host');
        $port = Hydra::getEmulator()->getConfigManager()->get('server.port');

        $this->loop = Loop::get();
        $this->tcpServer = new TcpServer("{$host}:{$port}", $this->loop);

        $this->tcpServer->on('connection', function (ConnectionInterface $connection) {
            $client = $this->clientManager->addIfAbsent($connection);

            $this->logger->info(sprintf('[%s] connected. Total of connections: [%s]', $client->getId(), count($this->clientManager->getClients())));

            $connection->on('data', function ($data) use (&$client) {
                $this->packageManager->handle($data, $client);
            });

            $connection->on('close', function () use ($connection) {
                $this->clientManager->disposeClient($connection);
            });
        });

        $this->logger->info('NetworkManager initialized!');
        $this->logger->info("Server listening on {$host}:{$port}!");
    }

    public function getPackageManager(): IPackageManager
    {
        return $this->packageManager;
    }

    public function getClientManager(): IClientManager
    {
        return $this->clientManager;
    }
}