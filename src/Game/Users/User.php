<?php

namespace Emulator\Game\Users;

use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Users\Data\IUserData;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Users\Data\UserData;

class User implements IUser
{
    private IUserData $data;
    private IClient $client;

    public function __construct(array &$data)
    {
        $this->data = new UserData($data);
    }

    public function getData(): IUserData
    {
        return $this->data;
    }

    public function setClient(IClient $client): void
    {
        $this->client = $client;
    }

    public function getClient(): IClient
    {
        return $this->client;
    }
}