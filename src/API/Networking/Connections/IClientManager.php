<?php

namespace Emulator\Api\Networking\Connections;

use React\Socket\ConnectionInterface;
use Emulator\Api\Networking\Connections\IClient;

interface IClientManager
{
    public function getClients(): array;
    public function getClient(string $connectionHash): ?IClient;
    public function hasClient(string $connectionHash): bool;
    public function addIfAbsent(ConnectionInterface &$connection): IClient;
    public function disposeClient(ConnectionInterface $connection): void;
    public function getClientByTicket(string $ticket): ?IClient;
    public function getClientByUserId(int $userId): ?IClient;
    public function hasClientByUserId(int $userId): bool;
}