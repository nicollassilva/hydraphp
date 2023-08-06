<?php

namespace Emulator\Game\Rooms\Enums;

enum RoomStateEnum: string
{
    case OPEN = "open";
    case CLOSED = "closed";
    case PASSWORD = "password";
    case INVISIBLE = "invisible";

    public static function getState(string $state): RoomStateEnum
    {
        return match ($state) {
            "open" => RoomStateEnum::OPEN,
            "closed" => RoomStateEnum::CLOSED,
            "password" => RoomStateEnum::PASSWORD,
            "invisible" => RoomStateEnum::INVISIBLE,
            default => throw new \Exception("Invalid room state: " . $state),
        };
    }
}