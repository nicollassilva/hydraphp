<?php

namespace Emulator\Api\Game\Rooms\Types\Items;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\Types\Items\Data\IItemDefinition;

interface IItemManager
{
    public function initialize(): void;
    public function getLogger(): Logger;
    public function getItemById(string|int $id): ?IItemDefinition;
}