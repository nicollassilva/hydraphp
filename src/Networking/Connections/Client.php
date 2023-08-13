<?php

namespace Emulator\Networking\Connections;

use Emulator\Api\Game\Users\IUser;
use Emulator\Hydra;
use Emulator\Utils\Logger;
use React\Socket\ConnectionInterface;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

class Client implements IClient
{
    private readonly Logger $logger;

    private string $version = 'UNKNOW';
    private string $uniqueId;

    private ?IUser $user = null;

    public function __construct(
        private readonly string $id,
        private readonly ConnectionInterface $connection
    ) {
        $this->logger = new Logger(get_class($this));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function disconnect(): void
    {
        $this->connection->close();
        Hydra::getEmulator()->getNetworkManager()->getClientManager()->disposeClient($this->connection);

        if($this->getUser() && Hydra::$isDebugging) {
            $this->logger->info(sprintf('[%s] disconnected.', $this->getUser()->getData()->getUsername()));
        }
    }

    public function send(?IMessageComposer $message): IClient
    {
        if($message == null) return $this;

        if($message->getHeader() <= 0) {
            if(Hydra::$isDebugging) $this->logger->error(sprintf('[%s] Invalid composer header: %s', get_class($message), $message->getHeader()));
            
            return $this;
        }

        if(Hydra::$isDebugging) $this->logger->info(sprintf('[O] [%s] %s', $message->getHeader(), get_class($message)));

        $this->getConnection()->write($message->compose());

        return $this;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setUniqueId(string $uniqueId): void
    {
        $this->uniqueId = $uniqueId;
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function setUser(IUser $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?IUser
    {
        return $this->user;
    }
}