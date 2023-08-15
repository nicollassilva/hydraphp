<?php

namespace Emulator\Api\Game\Navigator;

use ArrayObject;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Navigator\Data\NavigatorFilterField;
use Emulator\Api\Game\Navigator\Data\{INavigatorPublicCategory,INavigatorCategory};

interface INavigatorManager
{
    public function initialize(): void;
    public function getLogger(): Logger;

    /** @return ArrayObject<int,IRoom> */
    public function getRoomsForView(string $category, ?IUser $user = null): ArrayObject;
    public function getCategoryByView(string $view): ?INavigatorCategory;

    /** @return ArrayObject<int,INavigatorPublicCategory> */
    public function getPublicCategories(): ArrayObject;
    public function getPublicCategoryById(int|string $id): ?INavigatorPublicCategory;

    public function getFlatCategoryById(int $id): ?INavigatorCategory;

    public function getFilterByKey(string $key, string $fallbackField = 'anything'): ?NavigatorFilterField;
}