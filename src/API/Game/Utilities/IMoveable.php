<?php

namespace Emulator\Api\Game\Utilities;

interface IMoveable
{
    public function moveTo(int $x, int $y): void;
}