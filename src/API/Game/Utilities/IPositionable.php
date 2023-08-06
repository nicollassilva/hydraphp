<?php

namespace Emulator\Api\Game\Utilities;

use Emulator\Game\Utilities\Position;

interface IPositionable
{
    public function getPosition(): Position;
    public function setPosition(Position $position): void;
}