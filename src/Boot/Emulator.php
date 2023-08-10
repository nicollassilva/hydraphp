<?php

namespace Emulator\Boot;

use Closure;
use Emulator\Utils\Logger;
use Emulator\Boot\HydraConfig;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Game\Users\UserManager;
use Emulator\Storage\ConnectorManager;
use Emulator\Networking\NetworkManager;
use Emulator\Game\Catalog\CatalogManager;
use Emulator\Api\Networking\INetworkManager;
use Emulator\Game\Rooms\Types\Items\ItemManager;
use Emulator\Storage\Compositions\IConnectorManager;

class Emulator
{
    private readonly Logger $logger;
    public readonly HydraConfig $configManager;
    private readonly INetworkManager $networkManager;
    private readonly IConnectorManager $connectorManager;

    public function __construct() {
        $this->logger = new Logger(get_class($this));

        $this->showAdvertisement();
        $this->startConfigManager();

        $this->startConnectorManager(function() {
            $this->getConfigManager()->loadEmulatorSettings();

            RoomManager::getInstance()->initialize();
            UserManager::getInstance()->initialize();
            ItemManager::getInstance()->initialize();
            CatalogManager::getInstance()->initialize();

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

    public function startConfigManager()
    {  
        $this->configManager = new HydraConfig();
    }

    public function startConnectorManager(Closure $onConnectionCallback): void
    {
        $this->connectorManager = new ConnectorManager(
            $this->configManager->get('hydra.db.host'),
            $this->configManager->get('hydra.db.port'),
            $this->configManager->get('hydra.db.user'),
            $this->configManager->get('hydra.db.password'),
            $this->configManager->get('hydra.db.name'),
            $this->configManager->get('hydra.db.tcpKeepAlive'),
            $this->configManager->get('hydra.db.autoReconnect'),
            $onConnectionCallback
        );
    }

    public function getConfigManager(): HydraConfig
    {
        return $this->configManager;
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