<?php

namespace Emulator\Api\Game\Users;

use Emulator\Api\Game\Users\Data\IUserData;
use Emulator\Api\Game\Users\Data\IUserSettings;
use Emulator\Api\Networking\Connections\IClient;

interface IUser
{
    public function getData(): IUserData;
    public function getSettings(): IUserSettings;

    public function setClient(IClient $client): void;
    public function getClient(): IClient;
    
    public function dispose(): void;
    public function isDisposed(): bool;
}