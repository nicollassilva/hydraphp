<?php

namespace Emulator\Game\Navigator\Filters;

use ArrayObject;
use Emulator\Hydra;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Api\Game\Navigator\Data\INavigatorCategory;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Enums\{NavigatorDisplayOrder,NavigatorSearchAction,NavigatorDisplayMode};

class NavigatorHotelFilter implements INavigatorFilter
{
    public const FILTER_NAME = 'hotel_view';

    /** @return ArrayObject<NavigatorSearchList> */
    public function getFilterResult(): ArrayObject
    {
        $index = 0;

        /** @var ArrayObject<NavigatorSearchList> */
        $searchLists = new ArrayObject;

        $searchLists->append(new NavigatorSearchList(
            $index,
            'popular',
            '',
            NavigatorSearchAction::None,
            NavigatorListMode::from(Hydra::getEmulator()->getConfigManager()->get('hotel.navigator.popular.listtype')),
            NavigatorDisplayMode::Visible,
            false,
            true, // show invisible rooms
            NavigatorDisplayOrder::OrderNumeric,
            -1,
            NavigatorManager::getInstance()->getRoomsForView('popular')
        ));
        
        $popularRoomsByCategory = RoomManager::getInstance()->getPopularRoomsByCategory(
            Hydra::getEmulator()->getConfigManager()->get('hotel.navigator.popular.amount')
        );

        foreach ($popularRoomsByCategory as $rooms) {
            $firstRoom = $rooms->offsetGet(0);

            if(empty($firstRoom) || !($firstRoom->getData()->getCategory() instanceof INavigatorCategory)) continue;

            $searchLists->append(new NavigatorSearchList(
                ++$index,
                $firstRoom->getData()->getCategory()->getCaption(),
                $firstRoom->getData()->getCategory()->getCaption(),
                NavigatorSearchAction::None,
                NavigatorListMode::List,
                NavigatorDisplayMode::Visible,
                true,
                true, // show invisible rooms
                NavigatorDisplayOrder::OrderNumeric,
                $firstRoom->getData()->getCategory()->getOrder(),
                $rooms
            ));
        }

        unset($index, $popularRoomsByCategory);

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