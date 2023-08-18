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

        $this->writeInt(round($room->getModel()->getMapSize() / $room->getModel()->getMapSizeY()));
        $this->writeInt($room->getModel()->getMapSize());

        for ($y = 0; $y < $room->getModel()->getMapSizeY(); $y++) {
            for ($x = 0; $x < $room->getModel()->getMapSizeX(); $x++) {
                $roomTile = $room->getModel()->getTile($x, $y);

                if(!is_null($roomTile)) {
                    $this->writeShort($roomTile->getRelativeHeight());
                } else {
                    $this->writeShort(pow(2, 15) - 1);
                }
            }
        }
    }
}