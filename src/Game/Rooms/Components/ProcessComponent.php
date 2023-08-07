<?php

namespace Emulator\Game\Rooms\Components;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Utilities\PeriodicExecution;
use Emulator\Api\Game\Rooms\Components\IProcessComponent;
use Emulator\Game\Rooms\Types\Entities\RoomEntity;

class ProcessComponent extends PeriodicExecution implements IProcessComponent
{
    private readonly Logger $logger;
    
    private bool $isProcessing = false;

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
            $this->processEntity($entity);
        }

        $this->isProcessing = false;
    }

    private function processEntity(RoomEntity $entity): void
    {
        if(!empty($entity->getWalkingPath())) {
            $entity->setProcessingPath($entity->getWalkingPath());

            $entity->setWalkingPath([]);
        }

        if($entity->isWalking()) {
            $nextPosition = $entity->getProcessingPath()[0];
            $entity->incrementPreviousStep();

            unset($entity->getProcessingPath()[0]);

            if(count($entity->getProcessingPath()) > 1) {
                $entity->setFutureStep($entity->getProcessingPath()[1]);
            }

        }
    }

    public function getRoom(): IRoom
    {
        return $this->room;
    }
}