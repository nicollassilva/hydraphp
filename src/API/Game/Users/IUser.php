<?php

namespace Emulator\Api\Game\Users;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Api\Game\Users\Data\{IUserData,IUserSettings};

interface IUser
{
    public function getData(): IUserData;
    public function getSettings(): IUserSettings;

    public function setClient(IClient $client): void;
    public function getClient(): ?IClient;
    
    public function dispose(): void;
    public function isDisposed(): bool;

    public function setEntity(?UserEntity $entity): ?UserEntity;
    public function getEntity(): ?UserEntity;

}