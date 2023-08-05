<?php

namespace Emulator\Api\Game\Users;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;

interface IUserManager
{
    public function getLogger(): Logger;
    public function initialize(): void;
    public function loadUser(string $ticket): IUser;
}