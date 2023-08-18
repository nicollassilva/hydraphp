<?php

namespace Emulator\Game\Rooms;

abstract class RoomEnvironmentData
{
    public const ROOM_TICK_MS = 0.5;
    public const DISPOSE_INACTIVE_ROOMS_MS = 120;
    public const IDLE_CYCLES_BEFORE_DISPOSE = 60;

    public static int $maximumRoomsAllowed = 25;
}