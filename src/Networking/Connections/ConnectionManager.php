<?php

namespace Emulator\Networking\Connections;

use React\Socket\ConnectionInterface;
use Emulator\Networking\Connections\Client;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Api\Networking\Connections\IConnectionManager;

class ConnectionManager implements IConnectionManager
{
    private array $activeClients = [];

    public function getClients(): array
    {
        return $this->activeClients;
    }

    public function addIfAbsent(ConnectionInterface &$connection): IClient
    {
        $connectionHash = spl_object_hash($connection);

        if($client = $this->getClient($connectionHash)) {
            return $client;
        }

        $this->activeClients[$connectionHash] = new Client($connectionHash, $connection);

        return $this->getClient($connectionHash);
    }

    public function getClient(string $connectionHash): ?IClient
    {
        if($this->hasClient($connectionHash)) {
            return $this->activeClients[$connectionHash];
        }

        return null;
    }

    public function hasClient(string $connectionHash): bool
    {
        return isset($this->activeClients[$connectionHash]);
    }

    public function disposeClient(ConnectionInterface $connection): void
    {
        unset($this->activeClients[spl_object_hash($connection)]);
    }
}