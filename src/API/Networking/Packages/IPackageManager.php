<?php

namespace Emulator\Api\Networking\Packages;

use Emulator\Api\Networking\Connections\IClient;

interface IPackageManager
{
    public function handle(mixed $data, IClient $client): void;
}