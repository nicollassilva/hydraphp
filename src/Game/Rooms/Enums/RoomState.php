<?php

namespace Emulator\Game\Rooms\Enums;

enum RoomState: int
{
    case Open = 0;
    case Closed = 1;
    case Password = 2;
    case Invisible = 3;

    public static function getState(string $state): RoomState
    {
        return match ($state) {
            "open" => RoomState::Open,
            "closed" => RoomState::Closed,
            "password" => RoomState::Password,
            "invisible" => RoomState::Invisible,
            default => throw new \Exception("Invalid room state: " . $state),
        };
    }
}