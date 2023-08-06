<?php

namespace Emulator\Game\Users;

use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Users\Data\{UserData,UserSettings};
use Emulator\Api\Game\Users\Data\{IUserData,IUserSettings};

class User implements IUser
{
    private IUserData $data;
    private IUserSettings $settings;

    private IClient $client;

    private bool $isDisposed = false;

    public function __construct(array &$data)
    {
        $this->data = new UserData($data);
        $this->settings = new UserSettings($data);
    }

    public function getData(): IUserData
    {
        return $this->data;
    }

    public function getSettings(): IUserSettings
    {
        return $this->settings;
    }

    public function setClient(IClient $client): void
    {
        $this->client = $client;
    }

    public function getClient(): IClient
    {
        return $this->client;
    }

    public function dispose(): void
    {
        $this->setIsDisposed();
        $this->getClient()->disconnect();

        unset($this->client, $this->settings, $this->data);
    }

    private function setIsDisposed(bool $value = true): void
    {
        $this->isDisposed = $value;
    }

    public function isDisposed(): bool
    {
        return $this->isDisposed;
    }
}