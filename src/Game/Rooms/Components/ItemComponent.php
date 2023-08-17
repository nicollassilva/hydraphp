<?php

namespace Emulator\Game\Rooms\Components;

use ArrayObject;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Items\Data\IRoomItem;
use Emulator\Game\Items\Data\RoomFloorItem;
use Emulator\Storage\Repositories\Items\ItemRepository;

class ItemComponent
{
    private int $nextItemId = 0;

    /** @var ArrayObject<int,IRoomItem> $floorItems */
    private ArrayObject $floorItems;

    /** @var ArrayObject<int,IRoomItem> $floorItemsVirtualIdToDatabaseId */
    private ArrayObject $floorItemsVirtualIdToDatabaseId;

    /** @var ArrayObject<int,string> $floorItemsOwnerNames */
    private ArrayObject $floorItemsOwnerNames;
    
    /** @var ArrayObject<int,IRoomItem> $wallItems */
    private ArrayObject $wallItems;
    
    /** @var ArrayObject<int,IRoomItem> $wallItemsVirtualIdToDatabaseId */
    private ArrayObject $wallItemsVirtualIdToDatabaseId;

    /** @var ArrayObject<int,string> $wallItemsOwnerNames */
    private ArrayObject $wallItemsOwnerNames;

    private bool $itemsLoaded = false;

    public function __construct(private readonly IRoom $room)
    {
        $this->floorItems = new ArrayObject;
        $this->wallItems = new ArrayObject;

        $this->floorItemsOwnerNames = new ArrayObject;
        $this->wallItemsOwnerNames = new ArrayObject;

        $this->floorItemsVirtualIdToDatabaseId = new ArrayObject;
        $this->wallItemsVirtualIdToDatabaseId = new ArrayObject;
    }

    public function loadItems(): void
    {
        if($this->itemsLoaded) return;

        $this->itemsLoaded = true;

        ItemRepository::loadRoomItemsByRoomId($this->room, $this->floorItems, $this->wallItems);

        $this->setFloorItemsOwnerNames();
        $this->setWallItemsOwnerNames();

        $this->setFloorItemsVirtualIdToDatabaseId();
        $this->setWallItemsVirtualIdToDatabaseId();
    }

    private function setFloorItemsOwnerNames()
    {
        foreach($this->floorItems as $floorItem) {
            if($this->floorItemsOwnerNames->offsetExists($floorItem->getData()->getOwnerId())) continue;

            $this->floorItemsOwnerNames->offsetSet($floorItem->getData()->getOwnerId(), $floorItem->getData()->getOwnerName());
        }
    }

    private function setWallItemsOwnerNames()
    {
        foreach($this->wallItems as $wallItem) {
            if($this->wallItemsOwnerNames->offsetExists($wallItem->getData()->getOwnerId())) continue;

            $this->wallItemsOwnerNames->offsetSet($wallItem->getData()->getOwnerId(), $wallItem->getData()->getOwnerName());
        }
    }

    private function setFloorItemsVirtualIdToDatabaseId()
    {
        foreach($this->floorItems as $floorItem) {
            if($this->floorItemsVirtualIdToDatabaseId->offsetExists($floorItem->getVirtualId())) continue;

            $this->floorItemsVirtualIdToDatabaseId->offsetSet($floorItem->getVirtualId(), $floorItem->getData()->getId());
        }
    }

    private function setWallItemsVirtualIdToDatabaseId()
    {
        foreach($this->wallItems as $wallItem) {
            if($this->wallItemsVirtualIdToDatabaseId->offsetExists($wallItem->getVirtualId())) continue;

            $this->wallItemsVirtualIdToDatabaseId->offsetSet($wallItem->getVirtualId(), $wallItem->getData()->getId());
        }
    }

    /** @return ArrayObject<int,IRoomItem> */
    public function getFloorItems(): ArrayObject
    {
        return $this->floorItems;
    }

    /** @return ArrayObject<int,IRoomItem> */
    public function getWallItems(): ArrayObject
    {
        return $this->wallItems;
    }

    public function getNextItemId(): int
    {
        return ++$this->nextItemId;
    }

    /** @return ArrayObject<int,string> */
    public function getFloorItemsOwnerNames(): ArrayObject
    {
        return $this->floorItemsOwnerNames;
    }

    /** @return ArrayObject<int,string> */
    public function getWallItemsOwnerNames(): ArrayObject
    {
        return $this->wallItemsOwnerNames;
    }

    public function getFloorItemById(int $id): ?RoomFloorItem
    {
        if(!$this->floorItems->offsetExists($id)) return null;

        return $this->floorItems->offsetGet($id);
    }

    public function getFloorItemByVirtualId(int $id): ?RoomFloorItem
    {
        if(!$this->floorItemsVirtualIdToDatabaseId->offsetExists($id)) return null;

        return $this->floorItems->offsetGet($this->floorItemsVirtualIdToDatabaseId->offsetGet($id));
    }

    public function getWallItemByVirtualId(int $id): ?RoomWallItem
    {
        if(!$this->wallItemsVirtualIdToDatabaseId->offsetExists($id)) return null;

        return $this->wallItems->offsetGet($this->wallItemsVirtualIdToDatabaseId->offsetGet($id));
    }
}