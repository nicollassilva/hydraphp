<?php

namespace Emulator\Api\Game\Navigator;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Navigator\Data\{INavigatorPublicCategory,INavigatorCategory};

interface INavigatorManager
{
    public function initialize(): void;
    public function getLogger(): Logger;

    /** @return array<int,IRoom> */
    public function getRoomsForView(string $view, IUser $user): array;
    public function getCategoryByView(string $view): ?INavigatorCategory;
    
    /** @return array<int,INavigatorPublicCategory> */
    public function getPublicCategories(): array;
    public function getPublicCategoryById(int|string $id): ?INavigatorPublicCategory;

    public function getFlatCategoryById(int $id): ?INavigatorCategory;
}