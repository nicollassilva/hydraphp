<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomDataComposer extends MessageComposer
{
    public function __construct(IRoom &$room, IUser $user, bool $roomForward, bool $enterRoom)
    {
        $this->header = OutgoingHeaders::$roomDataComposer;

        $this->writeBoolean($enterRoom);
        $this->writeInt($room->getData()->getId());
        $this->writeString($room->getData()->getName());

        $this->writeInt($room->getData()->isPublic() ? 0 : $room->getData()->getOwnerId());
        $this->writeString($room->getData()->isPublic() ? "" : $room->getData()->getOwnerName());

        $this->writeInt($room->getData()->getState()->value);
        $this->writeInt($room->getData()->getCurrentUsers());
        $this->writeInt($room->getData()->getMaxUsers());
        $this->writeString($room->getData()->getDescription());
        $this->writeInt($room->getData()->getTradeMode());
        $this->writeInt($room->getData()->getScore());
        $this->writeInt(2);
        $this->writeInt($room->getData()->getCategory());

        if(empty($room->getData()->getTags())) {
            $this->writeInt(0);
        } else {
            $this->writeInt(count($room->getData()->getTags()));
            
            foreach($room->getData()->getTags() as $tag) {
                $this->writeString($tag);
            }
        }

        $base = 0;

        if ($room->getData()->getGuildId() > 0) {
            $base |= 2;
        }

        if (!$room->getData()->isPublic()) {
            $base |= 8;
        }

        if ($room->getData()->isPromoted()) {
            $base |= 4;
        }

        if ($room->getData()->allowPets()) {
            $base |= 16;
        }
        
        $this->writeInt($base);
        $this->writeBoolean($roomForward);
        $this->writeBoolean($room->getData()->isStaffPicked());
        $this->writeBoolean(false); // has guild
        $this->writeBoolean(false); // is muted

        $this->writeInt($room->getData()->getWhoCanMute());
        $this->writeInt($room->getData()->getWhoCanKick());
        $this->writeInt($room->getData()->getWhoCanBan());

        $this->writeBoolean(true); // has rights

        $this->writeInt($room->getData()->getChatMode());
        $this->writeInt($room->getData()->getChatWeight());
        $this->writeInt($room->getData()->getChatSpeed());
        $this->writeInt($room->getData()->getChatDistance());
        $this->writeInt($room->getData()->getChatProtection());
    }
}