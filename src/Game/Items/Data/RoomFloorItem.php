<?php

namespace Emulator\Game\Items\Data;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Items\Data\IRoomFloorItem;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

class RoomFloorItem extends RoomItem implements IRoomFloorItem
{
    public function __construct(array &$data, IRoom $room)
    {
        parent::__construct($data, $room);
    }

    public function compose(IMessageComposer $message): void
    {
        $message->writeInt($this->getVirtualId());
        $message->writeInt($this->getItemDefinition()->getSpriteId());
        $message->writeInt($this->getData()->getX());
        $message->writeInt($this->getData()->getY());
        $message->writeInt($this->getData()->getRotation());
        $message->writeString("{$this->getData()->getZ()}");

        if($this->getItemDefinition()->isAllowWalk() || $this->getItemDefinition()->isAllowSit()) {
            $message->writeString("{$this->getItemDefinition()->getStackHeight()}");
        } else {
            $message->writeString("");
        }
    }

    public function composeExtraData(IMessageComposer $message): void
    {
        if (!$this->getData()->isLimitedEdition()) return;

        $message->writeInt($this->getData()->getLimitedSells());
        $message->writeInt($this->getData()->getLimitedStack());
    }

    public function onEntityStepOn(): void
    {
        // Override this method
    }
}