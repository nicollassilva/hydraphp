<?php

namespace Emulator\Game\Navigator\Data;

use ArrayObject;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Api\Game\Navigator\Data\INavigatorPublicCategory;

class NavigatorPublicCategory implements INavigatorPublicCategory
{
    private readonly int $id;
    private readonly string $name;
    private readonly NavigatorListMode $listMode;
    private readonly int $order;

    /** @property ArrayObject<int,IRoom> */
    private ArrayObject $rooms;

    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->listMode = NavigatorListMode::from((int) $data['image']);
        $this->order = $data['order_num'];

        $this->rooms = new ArrayObject;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getListMode(): NavigatorListMode
    {
        return $this->listMode;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function addRoom(IRoom &$room): void
    {
        $this->rooms->offsetSet($room->getData()->getId(), $room);
    }

    /** @return ArrayObject<int,IRoom> */
    public function getRooms(): ArrayObject
    {
        return $this->rooms;
    }
}