<?php

namespace Emulator\Game\Navigator\Filters;

use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Enums\{NavigatorDisplayOrder,NavigatorSearchAction,NavigatorDisplayMode};

class NavigatorPublicFilter implements INavigatorFilter
{
    public const FILTER_NAME = 'official_view';

    /** @return array<NavigatorSearchList> */
    public function getFilterResult(): array
    {
        $index = 0;

        /** @var array<NavigatorSearchList> */
        $searchLists = [
            new NavigatorSearchList(
                $index,
                'official-root',
                '',
                NavigatorSearchAction::None,
                NavigatorListMode::Thumbnails,
                NavigatorDisplayMode::Visible,
                false,
                false,
                NavigatorDisplayOrder::OrderNumeric,
                -1,
                NavigatorManager::getInstance()->getRoomsForView('official-root')
            )
        ];
        
        $publicCategories = NavigatorManager::getInstance()->getPublicCategories();

        foreach ($publicCategories as $publicCategory) {
            $searchLists[] = new NavigatorSearchList(
                ++$index,
                '',
                $publicCategory->getName(),
                NavigatorSearchAction::None,
                NavigatorListMode::List,
                NavigatorDisplayMode::Visible,
                true,
                false,
                NavigatorDisplayOrder::OrderNumeric,
                $publicCategory->getOrder(),
                $publicCategory->getRooms()
            );
        }

        unset($index, $publicCategories);

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