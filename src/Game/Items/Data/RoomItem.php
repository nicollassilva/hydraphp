<?php

namespace Emulator\Game\Items\Data;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Items\ItemManager;
use Emulator\Game\Rooms\Types\RoomObject;
use Emulator\Game\Items\Data\RoomItemData;
use Emulator\Api\Game\Items\Data\IItemDefinition;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Rooms\Types\Entities\IUserEntity;
use Emulator\Api\Game\Items\Data\{IRoomItemData,IRoomItem};

class RoomItem extends RoomObject implements IRoomItem
{
    protected int $ticks = -1;

    private IRoomItemData $data;

    public function __construct(
        array &$data,
        IRoom $room
    ) {
        $this->data = new RoomItemData($data);
        
        parent::__construct(
            $room->getItemComponent()->getNextItemId(),
            $room,
            $room->getModel()->getTile($data['x'], $data['y'])
        );
    }

    public function getData(): IRoomItemData
    {
        return $this->data;
    }

    public function getItemDefinition(): ?IItemDefinition
    {
        return ItemManager::getInstance()->getItemDefinitionById($this->getData()->getItemDefinitionId());
    }

    public function compose(IMessageComposer $message): void
    {
        // Override this method.
    }

    public function composeExtraData(IMessageComposer $message): void
    {
        // Override this method.
    }

    public function onInteract(IUserEntity $entity, int $state): void
    {
        // Override this method.
    }
}