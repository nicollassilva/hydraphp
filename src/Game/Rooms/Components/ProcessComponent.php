<?php

namespace Emulator\Game\Rooms\Components;

use ArrayObject;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Rooms\RoomEnvironmentData;
use Emulator\Game\Utilities\PeriodicExecution;
use Emulator\Game\Rooms\Enums\RoomEntityStatus;
use Emulator\Api\Game\Rooms\Components\IProcessComponent;
use Emulator\Networking\Outgoing\Rooms\RoomUserStatusComposer;
use Emulator\Game\Rooms\Types\Entities\{RoomEntity,UserEntity};

class ProcessComponent extends PeriodicExecution implements IProcessComponent
{
    private readonly Logger $logger;
    
    private bool $isProcessing = false;

    /** @var ArrayObject<RoomEntity> */
    private ArrayObject $entitiesToUpdate;

    public function __construct(private readonly IRoom $room)
    {
        parent::__construct(RoomEnvironmentData::ROOM_TICK_MS);

        $this->logger = new Logger("Room Process [{$this->room->getData()->getName()} #{$this->room->getData()->getId()}]", false);

        $this->entitiesToUpdate = new ArrayObject;
    }

    public function tick(): void
    {
        if(!$this->started() || $this->isProcessing) return;

        $this->isProcessing = true;
        
        if(!$this->getRoom()->getEntityComponent()->getUserEntities()->count()) {
            $this->getRoom()->onIdleCycleChanged();
            $this->processComplete(resetRoomIdleCycle: false);

            return;
        }

        foreach($this->room->getEntityComponent()->getUserEntities() as $entity) {
            $this->processUserEntity($entity);
        }

        if($this->entitiesToUpdate->count()) {
            $this->getRoom()->broadcastMessage(new RoomUserStatusComposer($this->entitiesToUpdate));
        }

        foreach ($this->entitiesToUpdate as $entity) {
            $entity->setNeedsUpdate(false);

            if($nextTile = $entity->getNextTile()) {
                $entity->setCurrentTile($nextTile);
                unset($nextTile);
            }
        }

        $this->processComplete();
    }

    private function processUserEntity(UserEntity &$entity): void
    {
        if($entity->getUser()->isDisposed()) {
            $this->room->getEntityComponent()->removeUserEntity($entity);
            $this->markEntityNeedsUpdate($entity);
            return;
        }

        if($entity->hasStatus(RoomEntityStatus::Move)) {
            $entity->removeStatus(RoomEntityStatus::Move);
            $entity->removeStatus(RoomEntityStatus::Gesture);

            $this->markEntityNeedsUpdate($entity);
        }

        if(!empty($entity->getWalkingPath())) {
            $entity->setProcessingPath($entity->getWalkingPath());

            $entity->setWalkingPath([]);
        }

        if($entity->isWalking()) {
            $nextTile = $entity->getAndRemoveNextTile();
            $entity->incrementPreviousStep();

            $isLastStep = !$entity->getProcessingPath();

            if($isLastStep) {
                $entity->setWalkingPath([]);
                $entity->setProcessingPath([]);
            }

            $entity->setBodyRotation($entity->calculateNextRotation($nextTile->getPosition()));
            $entity->setHeadRotation($entity->getBodyRotation());

            $entity->setStatus(
                RoomEntityStatus::Move, "{$nextTile->getPosition()->getX()},{$nextTile->getPosition()->getY()},{$nextTile->getPosition()->getZ()}"
            );

            $this->markEntityNeedsUpdate($entity);
            $entity->setNextTile($nextTile);
        }
    }

    public function markEntityNeedsUpdate(RoomEntity $entity): void
    {
        if($this->entitiesToUpdate->offsetExists($entity->getVirtualId())) return;

        $entity->setNeedsUpdate(true);
        $this->entitiesToUpdate->offsetSet($entity->getVirtualId(), $entity);
    }

    public function getRoom(): IRoom
    {
        return $this->room;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    private function processComplete(bool $resetEntities = true, bool $resetRoomIdleCycle = true): void
    {
        $this->isProcessing = false;

        if($resetEntities) $this->entitiesToUpdate = new ArrayObject;
        if($resetRoomIdleCycle) $this->getRoom()->resetIdleCycle();
    }

    public function dispose(): void
    {
        $this->stop();

        foreach($this->entitiesToUpdate as $entity) {
            $this->getRoom()->getEntityComponent()->removeUserEntity($entity);
        }
    }
}