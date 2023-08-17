<?php

namespace Emulator\Networking\Outgoing\Rooms;

use ArrayObject;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomUserStatusComposer extends MessageComposer
{
    public function __construct(ArrayObject $entitiesToUpdate)
    {
        $this->header = OutgoingHeaders::$roomUserStatusComposer;

        $this->writeInt($entitiesToUpdate->count());

        foreach ($entitiesToUpdate as $entity) {
            $this->composeEntity($entity);
        }
    }

    private function composeEntity(UserEntity $entity): void
    {
        $this->writeInt($entity->getVirtualId());
        $this->writeInt($entity->getPosition()->getX());
        $this->writeInt($entity->getPosition()->getY());
        $this->writeString((string) $entity->getPosition()->getZ());
        $this->writeInt($entity->getHeadRotation());
        $this->writeInt($entity->getBodyRotation());

        $status = "/";

        foreach($entity->getStatus() as $key => $value) {
            $status .= "{$key} {$value}/";
        }

        $this->writeString($status);
    }
}