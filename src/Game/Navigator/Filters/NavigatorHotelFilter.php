<?php

namespace Emulator\Game\Navigator\Filters;

use Emulator\Api\Game\Navigator\Data\INavigatorCategory;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Enums\{NavigatorDisplayOrder,NavigatorSearchAction,NavigatorDisplayMode};
use Emulator\Game\Rooms\RoomManager;
use Emulator\Hydra;

class NavigatorHotelFilter implements INavigatorFilter
{
    public const FILTER_NAME = 'hotel_view';

    /** @return array<NavigatorSearchList> */
    public function getFilterResult(): array
    {
        $index = 0;

        /** @var array<NavigatorSearchList> */
        $searchLists = [
            new NavigatorSearchList(
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
            )
        ];
        
        $popularRoomsByCategory = RoomManager::getInstance()->getPopularRoomsByCategory(
            Hydra::getEmulator()->getConfigManager()->get('hotel.navigator.popular.amount')
        );

        foreach ($popularRoomsByCategory as $rooms) {
            $firstRoom = $rooms[0];

            if(empty($firstRoom) || !($firstRoom->getData()->getCategory() instanceof INavigatorCategory)) continue;

            $searchLists[] = new NavigatorSearchList(
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
            );
        }

        unset($index, $popularRoomsByCategory);

        return $searchLists;
    }

    /** @param array<NavigatorSearchList> $resultList */
    public function getRooms(array $resultList): array
    {
        $rooms = [];

        foreach ($resultList as $list) {
            $rooms = array_merge($rooms, $list->getRooms());
        }

        return $rooms;
    }
}