<?php

namespace Emulator\Game\Navigator\Data;

use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Api\Game\Navigator\Data\INavigatorCategory;

class NavigatorCategory implements INavigatorCategory
{
    private readonly int $id;
    private readonly int $minRank;
    private readonly string $caption;
    private readonly string $captionSave;
    private readonly bool $canTrade;
    private readonly int $maxUsersCount;
    private readonly bool $isOfficial;
    private readonly NavigatorListMode $displayMode;
    private readonly int $order;
    
    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->minRank = $data['min_rank'];
        $this->caption = $data['caption'];
        $this->captionSave = $data['caption_save'];
        $this->canTrade = (bool) $data['can_trade'];
        $this->maxUsersCount = $data['max_user_count'];
        $this->isOfficial = (bool) $data['public'];
        $this->displayMode = NavigatorListMode::from($data['list_type']);
        $this->order = $data['order_num'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMinRank(): int
    {
        return $this->minRank;
    }

    public function getCaption(): string
    {
        return $this->caption;
    }

    public function getCaptionSave(): string
    {
        return $this->captionSave;
    }

    public function canTrade(): bool
    {
        return $this->canTrade;
    }

    public function getMaxUsersCount(): int
    {
        return $this->maxUsersCount;
    }

    public function isOfficial(): bool
    {
        return $this->isOfficial;
    }

    public function getDisplayMode(): NavigatorListMode
    {
        return $this->displayMode;
    }

    public function getOrder(): int
    {
        return $this->order;
    }
}