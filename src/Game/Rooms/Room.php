<?php

namespace Emulator\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Rooms\Data\{IRoomData, IRoomModel};

class Room implements IRoom
{
    private IRoomData $data;
    private readonly Logger $logger;

    private readonly IRoomModel $model;

    public function __construct(IRoomData &$roomData)
    {
        $this->data = $roomData;
        $this->logger = new Logger(get_class($this));

        $this->model = RoomManager::getInstance()->getRoomModelsComponent()->getRoomModelByName($this->data->getModel());
    }

    public function getData(): IRoomData
    {
        return $this->data;
    }
}