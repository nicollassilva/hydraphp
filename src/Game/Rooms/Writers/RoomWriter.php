<?php

namespace Emulator\Game\Rooms\Writers;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

abstract class RoomWriter
{
    public static function forRoom(IRoom &$room, IMessageComposer $message)
    {
        $message->writeInt($room->getData()->getId());
        $message->writeString($room->getData()->getName());

        $message->writeInt($room->getData()->isPublic() ? 0 : $room->getData()->getOwnerId());
        $message->writeString($room->getData()->isPublic() ? "" : $room->getData()->getOwnerName());

        $message->writeInt($room->getData()->getState()->value);
        $message->writeInt($room->getEntityComponent()->getUserEntitiesCount());
        $message->writeInt($room->getData()->getMaxUsers());
        $message->writeString($room->getData()->getDescription());
        $message->writeInt($room->getData()->getTradeMode());
        $message->writeInt($room->getData()->getScore());
        $message->writeInt(0);
        $message->writeInt($room->getData()->getCategoryId());

        if(empty($room->getData()->getTags())) {
            $message->writeInt(0);
        } else {
            $message->writeInt(count($room->getData()->getTags()));
            
            foreach($room->getData()->getTags() as $tag) {
                $message->writeString($tag);
            }
        }

        $base = 0;

        if ($room->getData()->getGuildId() > 0) $base |= 2;
        if (!$room->getData()->isPublic()) $base |= 8;
        if ($room->getData()->isPromoted()) $base |= 4;
        if ($room->getData()->allowPets()) $base |= 16;
        
        $message->writeInt($base);

        // check guild id

        // check promoted
    }
}