<?php

namespace Emulator\Game\Rooms\Data;

use Emulator\Api\Game\Rooms\Data\IChatBubble;

class ChatBubble implements IChatBubble
{
    public function __construct(
        private readonly string $name,
        private readonly int $type,
        private readonly string $permission,
        private readonly bool $isOverridable
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function isOverridable(): bool
    {
        return $this->isOverridable;
    }
}