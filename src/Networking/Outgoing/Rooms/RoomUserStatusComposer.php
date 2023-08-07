<?php

namespace Emulator\Networking\Outgoing\Rooms;

use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class RoomUserStatusComposer extends MessageComposer
{
    public function __construct(UserEntity &$entity)
    {
        $this->header = OutgoingHeaders::$roomUserStatusComposer;

        $this->writeInt32(1);
        $this->writeInt32(0); // $entity->getId()
        $this->writeInt32($entity->getPosition()->getX());
        $this->writeInt32($entity->getPosition()->getY());
        $this->writeString((string) $entity->getPosition()->getZ());
        $this->writeInt32($entity->getHeadRotation());
        $this->writeInt32($entity->getBodyRotation());

        $status = "/";

        foreach($entity->getStatus() as $key => $value) {
            $status .= "{$key} {$value}/";
        }

        $this->writeString($status);
    }
}