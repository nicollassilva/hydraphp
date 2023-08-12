<?php

namespace Emulator\Api\Game\Navigator\Filters;

use Emulator\Game\Navigator\Search\NavigatorSearchList;

interface INavigatorFilter
{
    /** @return array<NavigatorSearchList> */
    public function getFilterResult(): array;

    /** @param array<NavigatorSearchList> $resultList */
    public function getRooms(array $resultList): array;
}