<?php

namespace Emulator\Game\Items\Interactions\Floor;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Items\Data\RoomFloorItem;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Rooms\Types\Entities\IUserEntity;

class DefaultFloorItem extends RoomFloorItem
{
    public function __construct(array &$data, IRoom $room)
    {
        parent::__construct($data, $room);
    }
    
    public function onInteract(IUserEntity $entity, int $state): void
    {
        echo "DefaultFloorItem::onInteract() called" . PHP_EOL;
        echo "Entity: " . $entity->getUser()->getData()->getUsername() . PHP_EOL;
        echo "State: " . $state . PHP_EOL;
    }

    public function composeExtraData(IMessageComposer $message): void
    {
        $message->writeInt($this->getData()->isLimitedEdition() ? 256 : 0);
        $message->writeString($this->getData()->getExtraData());
        
        parent::composeExtraData($message);
    }
}