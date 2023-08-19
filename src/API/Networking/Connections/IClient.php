<?php

namespace Emulator\Api\Networking\Connections;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;
use React\Socket\ConnectionInterface;
use Emulator\Game\Utilities\Enums\MiddleAlertKeyTypes;
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
    public function disconnectAndDispose(): void;

    public function getLogger(): Logger;

    public function setUser(IUser $user): void;
    public function getUser(): ?IUser;

    public function sendMiddleAlert(MiddleAlertKeyTypes $errorKey, string $message): void;
}