<?php

namespace Emulator\Game\Rooms\Utils;

use Emulator\Game\Rooms\Enums\RoomChatEmotion;

abstract class ChatEmotion
{
    public static function getByMessage(string $message): RoomChatEmotion
    {
        return match(true) {
            str_contains($message, ":)") || str_contains($message, ":-)") || str_contains($message, "=)") || str_contains($message, "=]")
                => RoomChatEmotion::Smile,
            str_contains($message, ":D") || str_contains($message, "=D")
                => RoomChatEmotion::Laugh,
            str_contains($message, ":@") || str_contains($message, "=@") || str_contains($message, ">:(")
                => RoomChatEmotion::Angry,
            str_contains($message, ":o") || str_contains($message, ":O") || str_contains($message, "=o") || str_contains($message, "=O") || str_contains($message, ":0")
            || str_contains($message, "=0") || str_contains($message, "O.o") || str_contains($message, "o.O") || str_contains($message, "O.O")
                => RoomChatEmotion::Shocked,
            str_contains($message, ":(") || str_contains($message, "=(") || str_contains($message, ":-(") || str_contains($message, ":[") || str_contains($message, "=[")
                => RoomChatEmotion::Sad,
            default => RoomChatEmotion::None
        };
    }
}