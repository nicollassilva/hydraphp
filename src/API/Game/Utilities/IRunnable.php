<?php

namespace Emulator\Api\Game\Utilities;

interface IRunnable
{
    public function tick(): void;
    public function start(): void;
    public function stop(): void;
}