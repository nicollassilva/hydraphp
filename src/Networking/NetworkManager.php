<?php

namespace Emulator\Networking;

use Throwable;
use Emulator\Hydra;
use Revolt\EventLoop;
use Emulator\Utils\Logger;
use Amp\Socket\BindContext;
use Amp\Socket\ResourceServerSocket;
use Emulator\Api\Networking\INetworkManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Packages\PackageManager;
use Emulator\Networking\Connections\ClientManager;
use Emulator\Api\Networking\Packages\IPackageManager;
use Emulator\Api\Networking\Connections\IClientManager;

use function Amp\async;
use function Amp\Socket\listen;

class NetworkManager implements INetworkManager
{
    private readonly Logger $logger;

    private ResourceServerSocket $tcpServer;

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
        $host = Hydra::getEmulator()->getConfigManager()->get('hydra.server.flash.host');
        $port = Hydra::getEmulator()->getConfigManager()->get('hydra.server.flash.port');

        $bindContext = new BindContext();

        $bindContext->withoutTlsContext();

        $this->logger->info('NetworkManager initialized!');
        $this->logger->info("Server listening on {$host}:{$port}!");

        $this->tcpServer = listen("tcp://{$host}:{$port}", $bindContext);

        while($socket = $this->tcpServer->accept()) {
            async(function () use ($socket) {
                $client = $this->clientManager->addIfAbsent($socket, function(IClient $client) {
                    if(Hydra::$isDebugging) $this->logger->info(sprintf('[%s] connected. Total of connections: [%s]', $client->getId(), count($this->clientManager->getClients())));
                });

                try {
                    while ($data = $socket->read()) {
                        if($data === null) continue;

                        $this->packageManager->handle($data, $client);
                    }
                } catch (\Throwable $error) {                
                    $this->logger->error($error->getMessage());
                }

                $socket->onClose(function() use (&$client, $socket) {
                    if(!$client->getUser()) {
                        $this->clientManager->disposeClient($socket);
                        return;
                    }
    
                    $client->getUser()->dispose();
                });
            });
        }

        EventLoop::run();
    }

    public function getPackageManager(): IPackageManager
    {
        return $this->packageManager;
    }

    public function getClientManager(): IClientManager
    {
        return $this->clientManager;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }
}