<?php

namespace Emulator\Api\Game\Rooms\Data;

interface IChatBubble
{
    public function getName(): string;
    public function getType(): int;
    public function getPermission(): string;
    public function isOverridable(): bool;
}