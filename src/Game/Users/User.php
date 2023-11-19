<?php

namespace Emulator\Game\Users;

use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Game\Users\Components\{RoomsComponent};
use Emulator\Game\Users\Data\{UserData,UserSettings};
use Emulator\Api\Game\Users\Data\{IUserData,IUserSettings};
use Emulator\Utils\Logger;

class User implements IUser
{
    private readonly Logger $logger;

    private ?IUserData $data = null;
    private ?IUserSettings $settings = null;

    private ?IClient $client = null;
    private ?UserEntity $entity = null;

    private ?RoomsComponent $roomsComponent = null;

    private bool $isDisposed = false;

    public function __construct(array $data)
    {
        $this->data = new UserData($data);
        $this->settings = new UserSettings($data);

        $this->roomsComponent = new RoomsComponent($this);

        $this->logger = new Logger($this->data->getUsername(), false);
    }

    public function getData(): ?IUserData
    {
        return $this->data;
    }

    public function getSettings(): ?IUserSettings
    {
        return $this->settings;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }
    
    public function getRoomsComponent(): ?RoomsComponent
    {
        return $this->roomsComponent;
    }

    public function setClient(IClient $client): void
    {
        $this->client = $client;
    }

    public function getClient(): ?IClient
    {
        return $this->client;
    }

    public function dispose(): void
    {
        $this->setIsDisposed();

        if(!empty($this->getEntity())) {
            $this->getEntity()->dispose(true);
        }

        $this->getClient()->disconnectAndDispose();

        unset($this->client, $this->settings, $this->data, $this->roomsComponent, $this->entity);
    }

    private function setIsDisposed(bool $value = true): void
    {
        $this->isDisposed = $value;
    }

    public function isDisposed(): bool
    {
        return $this->isDisposed;
    }

    public function setEntity(?UserEntity $entity): ?UserEntity
    {
        $this->entity = $entity;

        return $this->entity;
    }

    public function getEntity(): ?UserEntity
    {
        return $this->entity;
    }
}