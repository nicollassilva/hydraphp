<?php

namespace Emulator\Networking\Connections;

use React\Socket\ConnectionInterface;
use Emulator\Networking\Connections\Client;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Api\Networking\Connections\IClientManager;

class ClientManager implements IClientManager
{
    /** @property array<string,IClient> */
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

    public function disposeClient(ConnectionInterface $connection, bool $needsDisconnectUser = false): void
    {
        unset($this->activeClients[spl_object_hash($connection)]);
    }

    public function getClientByTicket(string $ticket): ?IClient
    {
        return $this->getClientByDataProperty($ticket, "getTicket");
    }

    public function getClientByUserId(int $userId): ?IClient
    {
        return $this->getClientByDataProperty($userId, "getId");
    }

    public function hasClientByUserId(int $userId): bool
    {
        return $this->getClientByUserId($userId) !== null;
    }

    private function getClientByDataProperty(mixed $searchedValue, string $property): ?IClient
    {
        foreach($this->activeClients as $client) {
            if($client->getUser()?->getData()?->{$property}() === $searchedValue) {
                return $client;
            }
        }
        
        return null;
    }
}