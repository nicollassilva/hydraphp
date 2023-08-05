<?php

namespace Emulator;

use Emulator\Boot\Emulator;

abstract class Hydra
{
    public static Emulator $emulator;
    
    public static bool $isDebugging = false;

    public static function start(): void
    {
        self::$emulator = new Emulator();

        self::$isDebugging = self::$emulator->getConfigManager()->get('emulator.debug', false);
    }

    public static function getEmulator(): Emulator
    {
        return self::$emulator;
    }
}