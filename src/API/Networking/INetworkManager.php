<?php

namespace Emulator\Api\Networking;

use Emulator\Api\Networking\Packages\IPackageManager;
use Emulator\Api\Networking\Connections\IClientManager;

interface INetworkManager
{
    public function getPackageManager(): IPackageManager;
    public function getClientManager(): IClientManager;
}