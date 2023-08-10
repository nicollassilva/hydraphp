<?php

namespace Emulator\Game\Users;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Users\IUserManager;
use Emulator\Storage\Repositories\Users\UserRepository;

class UserManager implements IUserManager
{
    public static UserManager $instance;

    public readonly Logger $logger;

    private bool $isStarted = false;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));

        $this->initialize();
    }

    public static function getInstance(): UserManager
    {
        if (!isset(self::$instance)) self::$instance = new UserManager();

        return self::$instance;
    }

    public function initialize(): void
    {
        if ($this->isStarted) return;

        UserRepository::initialize();

        $this->isStarted = true;
        $this->logger->info("UserManager initialized.");
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function loadUser(string $ticket): IUser
    {
        return UserRepository::loadUser($ticket);
    }
}