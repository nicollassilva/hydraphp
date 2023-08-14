<?php

namespace Emulator\Game\Navigator\Filters;

use ArrayObject;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Enums\{NavigatorDisplayOrder,NavigatorSearchAction,NavigatorDisplayMode};

class NavigatorPublicFilter implements INavigatorFilter
{
    public const FILTER_NAME = 'official_view';

    /** @return ArrayObject<NavigatorSearchList> */
    public function getFilterResult(): ArrayObject
    {
        $index = 0;

        /** @var ArrayObject<NavigatorSearchList> */
        $searchLists = new ArrayObject;

        $searchLists->append(new NavigatorSearchList(
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
        ));
        
        $publicCategories = NavigatorManager::getInstance()->getPublicCategories();

        foreach ($publicCategories as $publicCategory) {
            $searchLists->append(
                new NavigatorSearchList(
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
                )
            );
        }

        unset($index, $publicCategories);

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