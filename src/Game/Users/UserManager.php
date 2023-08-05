<?php

namespace Emulator\Game\Users;

use Closure;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUserManager;
use Emulator\Api\Game\Users\IUser;
use Emulator\Storage\Repositories\Users\UserDataRepository;

class UserManager implements IUserManager
{
    public static UserManager $instance;

    public readonly Logger $logger;

    private bool $isStarted = false;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));
    }

    public static function getInstance(): UserManager
    {
        if (!isset(self::$instance)) self::$instance = new UserManager();

        return self::$instance;
    }

    public function initialize(): void
    {
        if ($this->isStarted) return;

        UserDataRepository::initialize();

        $this->isStarted = true;
        $this->logger->info("User manager initialized.");
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function loadUser(string $ticket): IUser
    {
        return UserDataRepository::loadUser($ticket);
    }
}