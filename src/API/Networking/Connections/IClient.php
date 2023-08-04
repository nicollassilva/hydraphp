<?php

namespace Emulator\Api\Networking\Connections;

use Emulator\Utils\Logger;
use React\Socket\ConnectionInterface;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

interface IClient
{
    public function getId(): string;
    public function getConnection(): ConnectionInterface;

    public function setVersion(string $version): void;
    public function getVersion(): string;

    public function setUniqueId(string $uniqueId): void;
    public function getUniqueId(): string;

    public function send(?IMessageComposer $message): IClient;
    public function disconnect(): void;

    public function getLogger(): Logger;
}