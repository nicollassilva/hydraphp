<?php

namespace Emulator\Game\Utilities;

use React\EventLoop\Loop;
use Emulator\Api\Game\Utilities\IRunnable;
use React\EventLoop\TimerInterface;

class PeriodicExecution implements IRunnable
{
    private bool $isActive = false;

    private TimerInterface $processTimer;

    public function __construct(
        private readonly float $delay
    ) {}

    public function getDelay(): int
    {
        return $this->delay;
    }

    public function start(): void
    {
        if($this->isActive) return;

        $this->isActive = true;

        $this->processTimer = Loop::addPeriodicTimer($this->delay, function() {
            $this->tick();
        });
    }

    public function stop(): void
    {
        if(!$this->isActive) return;

        $this->isActive = false;

        Loop::cancelTimer($this->processTimer);

        unset($this->processTimer);
    }

    public function tick(): void
    {
        // Override this method.
    }

    public function started(): bool
    {
        return $this->isActive;
    }
}