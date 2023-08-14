<?php

namespace Emulator\Game\Navigator\Filters;

use ArrayObject;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Enums\{NavigatorDisplayOrder,NavigatorSearchAction,NavigatorDisplayMode};

class NavigatorRoomEventFilter implements INavigatorFilter
{
    public const FILTER_NAME = 'roomads_view';

    /** @return ArrayObject<NavigatorSearchList> */
    public function getFilterResult(): ArrayObject
    {
        /** @var ArrayObject<NavigatorSearchList> */
        $searchLists = new ArrayObject;

        $searchLists->append(new NavigatorSearchList(
            0,
            'categories',
            '',
            NavigatorSearchAction::None,
            NavigatorListMode::List,
            NavigatorDisplayMode::Visible,
            false,
            true, // show invisible
            NavigatorDisplayOrder::Activity,
            0,
            NavigatorManager::getInstance()->getRoomsForView('categories')
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
}