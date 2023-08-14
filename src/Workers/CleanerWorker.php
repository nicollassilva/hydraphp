<?php

namespace Emulator\Workers;

use Emulator\Game\Rooms\RoomManager;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class CleanerWorker
{
    public static ?CleanerWorker $instance = null;

    private const CLEANER_WORKER_INTERVAL = 15;

    private int $lastInactiveRoomsDisposed = 0;

    private LoopInterface $loop;

    public function __construct()
    {
        $this->lastInactiveRoomsDisposed = time();
    }

    public static function initialize()
    {
        if(self::$instance instanceof CleanerWorker) return;

        self::$instance = new CleanerWorker;

        self::$instance->start();
    }

    public function start(): void
    {
        $this->loop = Loop::get();

        $this->loop->addPeriodicTimer(self::CLEANER_WORKER_INTERVAL, function() {
            $this->processCleanings();
        });
    }

    public function processCleanings(): void
    {
        $currentTime = time();

        if($currentTime - $this->lastInactiveRoomsDisposed > RoomManager::DISPOSE_INACTIVE_ROOMS_MS) {
            RoomManager::getInstance()->disposeInactiveRooms();

            $this->lastInactiveRoomsDisposed = $currentTime;
        }
    }
}