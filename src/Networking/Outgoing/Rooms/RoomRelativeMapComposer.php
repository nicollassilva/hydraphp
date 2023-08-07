<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomRelativeMapComposer extends MessageComposer
{
    public function __construct(IRoom &$room)
    {
        $this->header = OutgoingHeaders::$roomRelativeMapComposer;

        $this->writeInt32($room->getModel()->getMapSize() / $room->getModel()->getMapSizeY());
        $this->writeInt32($room->getModel()->getMapSize());

        for ($y = 0; $y < $room->getModel()->getMapSizeY(); $y++) {
            for ($x = 0; $x < $room->getModel()->getMapSizeX(); $x++) {
                $roomTile = $room->getModel()->getTile($x, $y);

                if(!empty($roomTile)) {
                    $this->writeInt16($roomTile->getRelativeHeight());
                } else {
                    $this->writeInt16(pow(2, 15) - 1);
                }
            }
        }
    }
}