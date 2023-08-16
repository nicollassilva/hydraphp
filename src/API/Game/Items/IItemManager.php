<?php

namespace Emulator\Api\Game\Items;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Items\Data\IItemDefinition;

interface IItemManager
{
    public function initialize(): void;
    public function getLogger(): Logger;
    public function getItemById(string|int $id): ?IItemDefinition;
}