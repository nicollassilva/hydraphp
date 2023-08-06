<?php

namespace Emulator\Api\Game\Rooms\Types\Entities;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;

interface IUserEntity
{
    public function getUser(): IUser;
    public function isKicked(): bool;
    public function getLogger(): Logger;
    public function clearStatus(): void;
    public function getStatus(): array;
}