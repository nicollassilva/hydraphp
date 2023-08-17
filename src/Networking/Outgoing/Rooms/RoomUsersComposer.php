<?php

namespace Emulator\Networking\Outgoing\Rooms;

use ArrayObject;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;
use Emulator\Game\Rooms\Types\Entities\UserEntity;

class RoomUsersComposer extends MessageComposer
{
    /** @param ArrayObject<int,UserEntity> $entities */
    public function __construct(?ArrayObject $entities, ?UserEntity $entity = null)
    {
        $this->header = OutgoingHeaders::$roomUsersComposer;

        if($entity instanceof UserEntity) {
            $this->writeInt(1);
            $this->composeUser($entity);
            return;
        }

        $this->writeInt($entities->count());

        foreach ($entities as $entity) {
            $this->composeUser($entity);
        }
    }

    private function composeUser(UserEntity $entity): void
    {
        $this->writeInt($entity->getUser()->getData()->getId());
        $this->writeString($entity->getUser()->getData()->getUsername());
        $this->writeString($entity->getUser()->getData()->getMotto());
        $this->writeString($entity->getUser()->getData()->getLook());
        $this->writeInt($entity->getVirtualId());
        $this->writeInt($entity->getPosition()->getX());
        $this->writeInt($entity->getPosition()->getY());
        $this->writeString((string) $entity->getPosition()->getZ());
        $this->writeInt($entity->getBodyRotation());
        $this->writeInt(1);
        $this->writeString($entity->getUser()->getData()->getGender());
        $this->writeInt(-1);
        $this->writeInt(-1);
        $this->writeString('');
        $this->writeString('');
        $this->writeInt($entity->getUser()->getSettings()->getAchievementScore());
        $this->writeBoolean(true);
    }
}