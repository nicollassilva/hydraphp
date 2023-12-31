<?php

namespace Emulator\Networking\Outgoing\Rooms;

use ArrayObject;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;
use Emulator\Game\Navigator\Search\NavigatorSearchList;

class NewNavigatorSearchResultsComposer extends MessageComposer
{
    /** @param ArrayObject<NavigatorSearchList> $resultList */
    public function __construct(string $category, string $search, ArrayObject $resultList)
    {
        $this->header = OutgoingHeaders::$newNavigatorSearchResultsComposer;

        $this->writeString($category);
        $this->writeString($search);
        $this->writeInt(count($resultList));

        foreach ($resultList as $list) {
            $list->compose($this);
        }
    }
}