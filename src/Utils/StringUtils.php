<?php

namespace Emulator\Utils;

abstract class StringUtils
{
    public static function getRandom(int $length): string
    {
        return random_bytes($length);
    }
}