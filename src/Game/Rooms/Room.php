<?php

namespace Emulator\Game\Rooms;

use Emulator\Hydra;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Writers\RoomWriter;
use Emulator\Game\Rooms\RoomEnvironmentData;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Rooms\Data\{IRoomData, IRoomModel};
use Emulator\Networking\Outgoing\Rooms\RemoveUserComposer;
use Emulator\Game\Rooms\Components\{EntityComponent, ItemComponent, MappingComponent, ProcessComponent};

class Room implements IRoom
{
    private IRoomData $data;
    private readonly Logger $logger;

    private IRoomModel $model;

    private ProcessComponent $processComponent;
    private MappingComponent $mappingComponent;
    private EntityComponent $entityComponent;
    private ItemComponent $itemComponent;

    private int $idleCycle = 0;

    public function __construct(IRoomData &$roomData)
    {
        $this->logger = new Logger("[Room {$roomData->getName()}]", false);

        $this->data = $roomData;
        $this->model = RoomManager::getInstance()->getRoomModelsComponent()->getRoomModelByName($this->data->getModel());

        $this->processComponent = new ProcessComponent($this);
        $this->mappingComponent = new MappingComponent($this);
        $this->entityComponent = new EntityComponent($this);
        $this->itemComponent = new ItemComponent($this);
    }

    public function initializeRoomProcess(): void
    {
        $this->getProcessComponent()->start();

        $this->getItemComponent()->loadItems();
        $this->mappingComponent->loadRoomHeighmap();
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

    public function getItemComponent(): ItemComponent
    {
        return $this->itemComponent;
    }

    public function broadcastMessage(IMessageComposer $message): IRoom
    {
        foreach ($this->entityComponent->getUserEntities() as $userEntity) {
            if (empty($userEntity->getUser()?->getClient()) || $userEntity->getUser()->isDisposed()) {
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

    public function getNextItemId(): int
    {
        return $this->itemComponent->getNextItemId();
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
        $this->idleCycle++;

        if ($this->idleCycle >= RoomEnvironmentData::IDLE_CYCLES_BEFORE_DISPOSE) $this->dispose();
    }

    public function resetIdleCycle(): void
    {
        $this->idleCycle = 0;
    }

    public function dispose(bool $completelyDispose = false): void
    {
        if (Hydra::$isDebugging && !$completelyDispose) $this->getLogger()->advertisement("Disposing room process [{$this->data->getName()} #{$this->data->getId()}]");

        $this->processComponent->dispose();

        if ($completelyDispose) {
            unset(
                $this->data,
                $this->processComponent,
                $this->mappingComponent,
                $this->entityComponent,
                $this->itemComponent,
                $this->model
            );
        }
    }

    public function onUserEntityRemoved(UserEntity $entity): void
    {
        $this->broadcastMessage(new RemoveUserComposer($entity->getVirtualId()));
    }

    public function canBeCompletelyDisposed(): bool
    {
        return !$this->getData()->isPublic()
            && !$this->getData()->isStaffPicked()
            && !Hydra::getEmulator()->getNetworkManager()->getClientManager()->hasClientByUserId($this->getData()->getOwnerId())
            && !$this->processComponent->started();
    }
}
