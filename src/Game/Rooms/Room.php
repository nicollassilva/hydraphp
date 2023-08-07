<?php

namespace Emulator\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Enums\RoomEntityType;
use Emulator\Game\Rooms\Types\Entities\RoomEntity;
use Emulator\Game\Rooms\Components\ProcessComponent;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Rooms\Data\{IRoomData, IRoomModel};

class Room implements IRoom
{
    private IRoomData $data;
    private readonly Logger $logger;

    private readonly IRoomModel $model;

    private ProcessComponent $processComponent;

    // @param array<RoomEntity>
    private array $entities = [];

    public function __construct(IRoomData &$roomData)
    {
        $this->data = $roomData;
        $this->logger = new Logger($roomData->getName(), false);

        $this->model = RoomManager::getInstance()->getRoomModelsComponent()->getRoomModelByName($this->data->getModel());
        $this->processComponent = new ProcessComponent($this);

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

    public function sendForAll(IMessageComposer $message): IRoom
    {
        foreach($this->getUserEntities() as $userEntity) {
            if(empty($userEntity->getUser()?->getClient()) || $userEntity->getUser()->isDisposed()) {
                continue;
            }

            $userEntity->getUser()->getClient()->send($message);
        }

        return $this;
    }

    /**
     * @return array<RoomEntity>
     */
    public function getUserEntities(): array
    {
        return array_filter($this->entities, 
            fn (RoomEntity $entity) => $entity->getType() == RoomEntityType::User
        );
    }

    public function addEntity(RoomEntity &$entity): void
    {
        $this->entities[$entity->getId()] = $entity;
    }

    public function getNextEntityId(): int
    {
        return count($this->entities);
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
}