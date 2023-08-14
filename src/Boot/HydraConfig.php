<?php

namespace Emulator\Boot;

use Emulator\Utils\Logger;
use Emulator\Api\Boot\IHydraConfig;
use Emulator\Storage\Repositories\EmulatorRepository;

class HydraConfig implements IHydraConfig
{   
    private readonly Logger $logger;

    private array $configurations = [];

    private bool $hydraConfigLoaded = false;
    private bool $emulatorSettingsLoaded = false;

    public function __construct(
        public readonly string $path = __DIR__ . '/../../config.json'
    )
    {
        $this->logger = new Logger(get_class($this));
        $this->parseConfig(true);
    }

    private function parseConfig(bool $forceLoad = false): void
    {
        if($this->hydraConfigLoaded && !$forceLoad) return;

        $config = json_decode(file_get_contents($this->path), true);

        foreach ($config as $key => $value) {
            $this->configurations[$key] = $value;
        }

        $this->hydraConfigLoaded = true;
    }

    public function loadEmulatorSettings(bool $forceLoad = false): void
    {
        if($this->emulatorSettingsLoaded && !$forceLoad) return;

        try {
            $hydraConfigCount = count($this->configurations);

            $emulatorSettings = EmulatorRepository::loadEmulatorConfigurations();

            $this->configurations = array_merge($this->configurations, $emulatorSettings);

            $this->logger->info(sprintf("Loaded %s hydra configurations and %s emulator settings.", $hydraConfigCount, count($emulatorSettings) - $hydraConfigCount));
        } catch (\Throwable $error) {
            $this->logger->error($error->getMessage());
        }
    }

    public function forceReload(): void
    {
        $this->parseConfig(true);
        $this->loadEmulatorSettings(true);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if(isset($this->configurations[$key])) {
            return $this->configurations[$key];
        }

        return $default;
    }
}