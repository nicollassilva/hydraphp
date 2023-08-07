<?php

namespace Emulator\Api\Boot;

interface IHydraConfig
{
    public function forceReload(): void;
    public function loadEmulatorSettings(bool $forceLoad = false): void;
    public function get(string $key, mixed $default = null): mixed;
}