<?php

namespace Emulator\Game\Utilities;

use Revolt\EventLoop;
use Emulator\Api\Game\Utilities\IRunnable;

class PeriodicExecution implements IRunnable
{
    private bool $isActive = false;

    private string $processTimer;

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

        $this->processTimer = EventLoop::repeat($this->delay, function() {
            $this->tick();
        });
    }

    public function stop(): void
    {
        if(!$this->isActive) return;

        $this->isActive = false;

        EventLoop::cancel($this->processTimer);

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