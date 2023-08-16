<?php

namespace Emulator\Game\Navigator\Filters;

use ArrayObject;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Game\Navigator\Data\NavigatorFilterField;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Enums\{NavigatorDisplayMode, NavigatorSearchAction, NavigatorDisplayOrder};

class NavigatorUserViewFilter implements INavigatorFilter
{
    public const FILTER_NAME = 'myworld_view';

    public function __construct(
        private readonly IUser $user
    )
    {
    }

    /** @return ArrayObject<NavigatorSearchList> */
    public function getFilterResult(): ArrayObject
    {
        $index = 0;

        /** @var ArrayObject<NavigatorSearchList> $searchLists */
        $searchLists = new ArrayObject;

        $searchLists->append(new NavigatorSearchList(
            $index,
            'my',
            '',
            NavigatorSearchAction::None,
            NavigatorListMode::List,
            NavigatorDisplayMode::Visible,
            false,
            true, // show invisible
            NavigatorDisplayOrder::Activity,
            0,
            NavigatorManager::getInstance()->getRoomsForView('my-rooms', $this->user)
        ));

        return $searchLists;
    }

    /** @param ArrayObject<NavigatorSearchList> $resultList */
    public function getRooms(ArrayObject $resultList): ArrayObject
    {
        $rooms = new ArrayObject;

        foreach ($resultList as $list) {
            $rooms->append($list->getRooms());
        }

        return $rooms;
    }
    
    public function getFilterResultBySearch(NavigatorFilterField $field, string $search, int $categoryId): ArrayObject
    {
        return $this->getFilterResult();
    }
}