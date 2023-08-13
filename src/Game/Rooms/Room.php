<?php

namespace Emulator\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Writers\RoomWriter;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Rooms\Data\{IRoomData, IRoomModel};
use Emulator\Game\Rooms\Components\{EntityComponent,MappingComponent,ProcessComponent};

class Room implements IRoom
{
    private IRoomData $data;
    private readonly Logger $logger;

    private readonly IRoomModel $model;

    private ProcessComponent $processComponent;
    private MappingComponent $mappingComponent;
    private EntityComponent $entityComponent;

    private int $idleCycle = 0;

    public function __construct(IRoomData &$roomData)
    {
        $this->logger = new Logger($roomData->getName(), false);

        $this->data = $roomData;
        $this->model = RoomManager::getInstance()->getRoomModelsComponent()->getRoomModelByName($this->data->getModel());

        $this->processComponent = new ProcessComponent($this);
        $this->mappingComponent = new MappingComponent($this);
        $this->entityComponent = new EntityComponent($this);

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

    public function getMappingComponent(): MappingComponent
    {
        return $this->mappingComponent;
    }

    public function getEntityComponent(): EntityComponent
    {
        return $this->entityComponent;
    }

    public function broadcastMessage(IMessageComposer $message): IRoom
    {
        foreach($this->entityComponent->getUserEntities() as $userEntity) {
            if(empty($userEntity->getUser()?->getClient()) || $userEntity->getUser()->isDisposed()) {
                continue;
            }

            $userEntity->getUser()->getClient()->send($message);
        }

        return $this;
    }

    public function getNextEntityId(): int
    {
        return $this->entityComponent->getNextEntityId();
    }

    public function isOwner(IUser $user): bool
    {
        return $this->data->getOwnerId() == $user->getData()->getId();
    }

    public function getProcessComponent(): ProcessComponent
    {
        return $this->processComponent;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function compose(IMessageComposer $message): void
    {
        RoomWriter::forRoom($this, $message);
    }

    public function onIdleCycleChanged(): void
    {
        if(++$this->idleCycle >= RoomManager::IDLE_CYCLES_BEFORE_DISPOSE) $this->dispose();
    }

    public function dispose(): void
    {
        RoomManager::getInstance()->disposeRoom($this);

        $this->processComponent->dispose();

        unset($this->data, $this->processComponent, $this->mappingComponent, $this->entityComponent, $this->logger);
    }
}