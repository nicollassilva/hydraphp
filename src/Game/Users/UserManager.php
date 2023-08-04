<?php

namespace Emulator\Game\Users;

class UserManager
{
    public static UserManager $instance;

    public static function getInstance(): UserManager
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserManager();
        }

        return self::$instance;
    }
}