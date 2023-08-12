<?php

namespace Emulator\Api\Game\Navigator\Data;

use Emulator\Game\Navigator\Enums\NavigatorListMode;

interface INavigatorCategory
{
    public function getId(): int;
    public function getMinRank(): int;
    public function getCaption(): string;
    public function getCaptionSave(): string;
    public function canTrade(): bool;
    public function getMaxUsersCount(): int;
    public function isOfficial(): bool;
    public function getDisplayMode(): NavigatorListMode;
    public function getOrder(): int;
}