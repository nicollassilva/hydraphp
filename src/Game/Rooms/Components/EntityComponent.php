<?php

namespace Emulator\Game\Rooms\Components;

use ArrayObject;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Rooms\Types\Entities\UserEntity;

class EntityComponent
{
    /** @var ArrayObject<int,UserEntity> */
    private ArrayObject $userEntities;

    public function __construct(private readonly IRoom $room)
    {
        $this->userEntities = new ArrayObject();
    }

    public function getNextEntityId(): int
    {
        return $this->userEntities->count() + 1;
    }

    public function addUserEntity(UserEntity &$entity): void
    {
        $this->userEntities->offsetSet($entity->getId(), $entity);
    }

    public function removeUserEntity(UserEntity $entity): void
    {
        $this->userEntities->offsetUnset($entity->getId());

        $this->room->onUserEntityRemoved($entity);
    }

    /** @return ArrayObject<int,UserEntity> */
    public function getUserEntities(): ArrayObject
    {
        return $this->userEntities;
    }

    public function getUserEntitiesCount(): int
    {
        return $this->userEntities->count();
    }
}