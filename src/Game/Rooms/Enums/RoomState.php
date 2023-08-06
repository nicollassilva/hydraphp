<?php

namespace Emulator\Game\Rooms\Enums;

enum RoomState: int
{
    case OPEN = 0;
    case CLOSED = 1;
    case PASSWORD = 2;
    case INVISIBLE = 3;

    public static function getState(string $state): RoomState
    {
        return match ($state) {
            "open" => RoomState::OPEN,
            "closed" => RoomState::CLOSED,
            "password" => RoomState::PASSWORD,
            "invisible" => RoomState::INVISIBLE,
            default => throw new \Exception("Invalid room state: " . $state),
        };
    }
}