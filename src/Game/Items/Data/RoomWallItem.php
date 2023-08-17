<?php

namespace Emulator\Game\Items\Data;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Items\Data\IRoomWallItem;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

class RoomWallItem extends RoomItem implements IRoomWallItem
{
    public function __construct(array &$data, IRoom $room)
    {
        parent::__construct($data, $room);
    }

    public function compose(IMessageComposer $message): void
    {
        $message->writeString("{$this->getVirtualId()}");
        $message->writeInt($this->getItemDefinition()->getSpriteId());
        $message->writeString($this->getData()->getWallPosition());
        
        $message->writeString($this->getData()->getExtraData());
        $message->writeInt(-1);
        $message->writeInt(1);
        $message->writeInt($this->getData()->getOwnerId());
    }
}