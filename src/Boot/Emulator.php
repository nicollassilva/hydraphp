<?php

namespace Emulator\Boot;

use Closure;
use Emulator\Utils\Logger;
use Emulator\Boot\EmulatorConfig;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Storage\ConnectorManager;
use Emulator\Networking\NetworkManager;
use Emulator\Api\Networking\INetworkManager;
use Emulator\Storage\Compositions\IConnectorManager;

class Emulator
{
    private readonly Logger $logger;
    private readonly INetworkManager $networkManager;
    private readonly IConnectorManager $connectorManager;

    public function __construct(
        public readonly EmulatorConfig $config = new EmulatorConfig()
    ) {
        $this->logger = new Logger(get_class($this));

        $this->showAdvertisement();

        $this->startConnectorManager(function() {
            RoomManager::getInstance()->initialize();

            $this->startNetworkManager();
        });
    }

    private function showAdvertisement(): void
    {
        $this->logger->advertisement('░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░');
        $this->logger->advertisement('░░█▄█░▀▄▀░█▀▄▒█▀▄▒▄▀▄▒█▀▄░█▄█▒█▀▄░░');
        $this->logger->advertisement('░▒█▒█░▒█▒▒█▄▀░█▀▄░█▀█░█▀▒▒█▒█░█▀▒░░');
        $this->logger->advertisement('░░░ Made with love by @iNicollas ░░');
        $this->logger->advertisement('░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░');
    }

    public function startNetworkManager()
    {  
        $this->networkManager = new NetworkManager();
    }

    public function startConnectorManager(Closure $onConnectionCallback): void
    {
        $this->connectorManager = new ConnectorManager(
            $this->config->get('db.host'),
            $this->config->get('db.port'),
            $this->config->get('db.user'),
            $this->config->get('db.password'),
            $this->config->get('db.name'),
            $this->config->get('db.tcpKeepAlive'),
            $this->config->get('db.autoReconnect'),
            $onConnectionCallback
        );
    }

    public function getConfigManager(): EmulatorConfig
    {
        return $this->config;
    }

    public function getConnectorManager(): IConnectorManager
    {
        return $this->connectorManager;
    }

    public function getNetworkManager(): INetworkManager
    {
        return $this->networkManager;
    }
}