<?php

namespace Emulator\Storage\Repositories\Users;

use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Game\Users\User;
use Emulator\Api\Game\Users\IUser;
use Emulator\Storage\Repositories\EmulatorRepository;

abstract class UserDataRepository extends EmulatorRepository
{
    public static Logger $logger;

    public static function initialize()
    {
        self::$logger = new Logger(static::class);
    }

    public static function getLogger(): Logger
    {
        return self::$logger;
    }

    public static function loadUser(string $ticket): ?IUser
    {
        $user = null;

        self::encapsuledSelect("SELECT * FROM users WHERE auth_ticket = ?", function(QueryResult $result) use (&$user) {
            if(empty($result->resultRows)) return;

            $user = new User($result->resultRows[0]);
        }, [$ticket]);

        return $user;
    }
}