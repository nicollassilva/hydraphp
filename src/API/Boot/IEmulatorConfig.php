<?php

namespace Emulator\Api\Boot;

interface IEmulatorConfig
{
    public function isLoaded(): bool;
    public function forceReload(): void;
    public function get(string $key, mixed $default = null): mixed;
}