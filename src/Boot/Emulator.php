<?php

namespace Emulator\Boot;

use Emulator\Hydra;
use Emulator\Utils\Logger;
use Emulator\Workers\CleanerWorker;
use Emulator\Game\Items\ItemManager;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Game\Users\UserManager;
use Emulator\Storage\ConnectorManager;
use Emulator\Networking\NetworkManager;
use Emulator\Game\Catalog\CatalogManager;
use Emulator\Api\Networking\INetworkManager;
use Emulator\Game\Navigator\NavigatorManager;

class Emulator
{
    private readonly Logger $logger;
    public ?HydraConfig $configManager = null;
    private ?INetworkManager $networkManager = null;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));
    }

    private function showAdvertisement(): void
    {
        $this->logger->advertisement('░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░');
        $this->logger->advertisement('░░█▄█░▀▄▀░█▀▄▒█▀▄▒▄▀▄▒█▀▄░█▄█▒█▀▄░░');
        $this->logger->advertisement('░▒█▒█░▒█▒▒█▄▀░█▀▄░█▀█░█▀▒▒█▒█░█▀▒░░');
        $this->logger->advertisement('░░░ Made with love by @iNicollas ░░');
        $this->logger->advertisement('░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░');
    }

    public function startNetworkManager(): void
    {
        $this->networkManager = new NetworkManager();
    }

    public function startConfigManager(): void
    {
        $this->configManager = new HydraConfig();
    }

    public function startEmulator(): void
    {
        $this->showAdvertisement();
        $this->startConfigManager();

        Hydra::$isDebugging = $this->getConfigManager()->get('hydra.emulator.debug', false);

        ConnectorManager::getInstance()->initialize();

        $this->getConfigManager()->loadEmulatorSettings();

        ItemManager::getInstance()->initialize();
        NavigatorManager::getInstance()->initialize();
        RoomManager::getInstance()->initialize();
        UserManager::getInstance()->initialize();
        CatalogManager::getInstance()->initialize();

        $this->startNetworkManager();

        // CleanerWorker::initialize();
    }

    public function getConfigManager(): HydraConfig
    {
        return $this->configManager;
    }

    public function getNetworkManager(): INetworkManager
    {
        return $this->networkManager;
    }
}