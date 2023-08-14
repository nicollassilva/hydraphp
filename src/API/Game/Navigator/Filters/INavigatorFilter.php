<?php

namespace Emulator\Api\Game\Navigator\Filters;

use ArrayObject;
use Emulator\Game\Navigator\Search\NavigatorSearchList;

interface INavigatorFilter
{
    /** @return ArrayObject<NavigatorSearchList> */
    public function getFilterResult(): ArrayObject;

    /** @param ArrayObject<NavigatorSearchList> $resultList */
    public function getRooms(ArrayObject $resultList): ArrayObject;
}