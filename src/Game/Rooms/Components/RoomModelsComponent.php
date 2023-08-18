<?php

namespace Emulator\Game\Rooms\Components;

use Emulator\Api\Game\Rooms\Data\IRoomModel;
use Emulator\Storage\Repositories\Rooms\RoomRepository;

class RoomModelsComponent
{
    // @param array<int, IRoomModel>
    private readonly array $roomModels;

    public function __construct()
    {
        $this->roomModels = RoomRepository::loadRoomModels();
    }

    public function getRoomModels(): array
    {
        return $this->roomModels;
    }

    public function getRoomModelByName(string $name): ?IRoomModel
    {
        return $this->roomModels[$name] ?? null;
    }

    public function roomModelExists(string $name): bool
    {
        return isset($this->roomModels[$name]);
    }
}