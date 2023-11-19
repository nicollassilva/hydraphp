<?php

namespace Emulator\Api\Networking\Connections;

use Closure;
use Amp\Socket\ResourceSocket;
use Emulator\Api\Networking\Connections\IClient;

interface IClientManager
{
    public function getClients(): array;
    public function getClient(string $connectionHash): ?IClient;
    public function hasClient(string $connectionHash): bool;
    public function addIfAbsent(ResourceSocket &$connection, ?Closure $successCallback = null): IClient;
    public function disposeClient(ResourceSocket $connection): void;
    public function getClientByTicket(string $ticket): ?IClient;
    public function getClientByUserId(int $userId): ?IClient;
    public function hasClientByUserId(int $userId): bool;
}