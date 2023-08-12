<?php

namespace Emulator\Game\Navigator\Data;

use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Api\Game\Navigator\Data\INavigatorPublicCategory;

class NavigatorPublicCategory implements INavigatorPublicCategory
{
    private readonly int $id;
    private readonly string $name;
    private readonly NavigatorListMode $listMode;
    private readonly int $order;

    /** @var array<int,IRoom> */
    private array $rooms = [];

    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->listMode = NavigatorListMode::from((int) $data['image']);
        $this->order = $data['order_num'];
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
        $this->rooms[$room->getData()->getId()] = $room;
    }

    /** @return array<int,IRoom> */
    public function getRooms(): array
    {
        return $this->rooms;
    }
}