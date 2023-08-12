<?php

namespace Emulator\Api\Game\Navigator;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;

interface INavigatorFilterManager
{
    public function initialize(): void;
    public function getLogger(): Logger;
    public function getFilterForView(string &$view): ?INavigatorFilter;
}