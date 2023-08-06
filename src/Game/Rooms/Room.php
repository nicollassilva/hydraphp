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

        $this->loadHeightmap();
    }

    private function loadHeightmap(): void
    {
        // Commented because items are not implemented yet.
        // 
        // if(empty($this->getModel())) return;

        // for($x = 0; $x < $this->getModel()->getMapSizeX(); $x++) {
        //     for($y = 0; $y < $this->getModel()->getMapSizeY(); $y++) {
        //         $tile = $this->getModel()->getTile($x, $y);

        //         if($tile) $this->updateTileInitially($tile);
        //     }
        // }
    }

    public function getData(): IRoomData
    {
        return $this->data;
    }

    public function getModel(): IRoomModel
    {
        return $this->model;
    }
}