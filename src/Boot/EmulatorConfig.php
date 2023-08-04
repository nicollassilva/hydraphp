<?php

namespace Emulator\Boot;

use Emulator\Api\Boot\IEmulatorConfig;

class EmulatorConfig implements IEmulatorConfig
{   
    private array $configs = [];

    public function __construct(
        public readonly string $path = __DIR__ . '/../../config.json'
    )
    {
        $this->parseConfig();
    }

    private function parseConfig(bool $forceLoad = false): void
    {
        if($this->isLoaded() && !$forceLoad) return;

        $config = json_decode(file_get_contents($this->path), true);

        foreach ($config as $key => $value) {
            $this->configs[$key] = $value;
        }
    }

    public function isLoaded(): bool
    {
        return ! empty($this->configs);
    }

    public function forceReload(): void
    {
        $this->parseConfig(true);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if(isset($this->configs[$key])) {
            return $this->configs[$key];
        }

        return $default;
    }
}