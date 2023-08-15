<?php

namespace Emulator\Game\Rooms\Components;

use Emulator\Game\Rooms\Data\ChatBubble;
use Emulator\Api\Game\Rooms\Data\IChatBubble;

class ChatBubblesComponent
{
    /** @property array<int,IChatBubble> */
    private readonly array $bubbles;

    private bool $isLoaded = false;

    public function __construct()
    {
        $this->loadChatBubbles();
    }

    private function loadChatBubbles(bool $forceLoad = false): void
    {
        if ($this->isLoaded && !$forceLoad) return;

        $bubbleId = 0;

        $this->bubbles = [
            new ChatBubble("default", $bubbleId, "", true),
            new ChatBubble("alert", ++$bubbleId, "", true),
            new ChatBubble("bot", ++$bubbleId, "", true),
            new ChatBubble("red", ++$bubbleId, "", true),
            new ChatBubble("blue", ++$bubbleId, "", true),
            new ChatBubble("yellow", ++$bubbleId, "", true),
            new ChatBubble("green", ++$bubbleId, "", true),
            new ChatBubble("black", ++$bubbleId, "", true),
            new ChatBubble("fortune_teller", ++$bubbleId, "", true),
        ];

        $this->isLoaded = true;
    }

    /** @return array<int,IChatBubble> */
    public function getChatBubbles(): array
    {
        return $this->bubbles;
    }

    public function getChatBubbleById(int $id): ?IChatBubble
    {
        return $this->bubbles[$id] ?? null;
    }
}