<?php

namespace Emulator\Game\Rooms\Components;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\PeriodicExecution;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Api\Game\Rooms\Components\IProcessComponent;
use Emulator\Game\Rooms\Enums\RoomEntityStatus;
use Emulator\Game\Rooms\Types\Entities\RoomEntity;
use Emulator\Networking\Outgoing\Rooms\RoomUserStatusComposer;

class ProcessComponent extends PeriodicExecution implements IProcessComponent
{
    private readonly Logger $logger;
    
    private bool $isProcessing = false;

    /** @var RoomEntity[] */
    private array $entitiesToUpdate = [];

    public function __construct(
        private readonly IRoom $room
    ) {
        parent::__construct(0.500);
        
        $this->logger = new Logger("Room Process [{$this->room->getData()->getId()} #{$this->room->getData()->getId()}]", false);
    }

    public function tick(): void
    {
        if(!$this->started() || $this->isProcessing) return;

        $this->isProcessing = true;

        foreach($this->room->getUserEntities() as $entity) {
            $this->processUserEntity($entity);
        }

        if(count($this->entitiesToUpdate)) {
            $this->getRoom()->sendForAll(new RoomUserStatusComposer(null, $this->entitiesToUpdate));
        }

        foreach ($this->entitiesToUpdate as $entity) {
            $entity->setNeedsUpdate(false);

            if($nextTile = $entity->getNextTile()) {
                $entity->setCurrentTile($nextTile);
                unset($nextTile);
            }
        }

        $this->entitiesToUpdate = [];
        $this->isProcessing = false;
    }

    private function processUserEntity(UserEntity $entity): void
    {
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

            $entity->setStatus(RoomEntityStatus::Move,
                sprintf("%s,%s,%s", $nextTile->getPosition()->getX(), $nextTile->getPosition()->getY(), $nextTile->getPosition()->getZ())
            );

            $this->markEntityNeedsUpdate($entity);
            $entity->setNextTile($nextTile);
        }
    }

    public function markEntityNeedsUpdate(RoomEntity $entity): void
    {
        if(in_array($entity, $this->entitiesToUpdate)) return;

        $entity->setNeedsUpdate(true);
        $this->entitiesToUpdate[] = $entity;
    }

    public function getRoom(): IRoom
    {
        return $this->room;
    }
}