<?php

namespace Emulator\Boot;

use Emulator\Utils\Logger;
use Emulator\Boot\EmulatorConfig;
use Emulator\Game\Users\UserManager;
use Emulator\Networking\NetworkManager;

class Emulator
{
    private readonly Logger $logger;
    private NetworkManager $networkManager;

    public function __construct(
        public readonly EmulatorConfig $config = new EmulatorConfig()
    ) {
        $this->logger = new Logger(get_class($this));
    }

    public function run()
    {
        $this->logger->success('Emulator started!');

        $this->networkManager = new NetworkManager();
    }

    public function getConfigManager(): EmulatorConfig
    {
        return $this->config;
    }
}