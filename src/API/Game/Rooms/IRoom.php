<?php

namespace Emulator\Api\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\Types\Entities\RoomEntity;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Rooms\Data\{IRoomData,IRoomModel};
use Emulator\Game\Rooms\Components\{MappingComponent,ProcessComponent};

interface IRoom
{
    public function getData(): IRoomData;
    public function getModel(): IRoomModel;

    public function isOwner(IUser $user): bool;
    
    public function addEntity(RoomEntity &$entity): void;

    public function sendForAll(IMessageComposer $message): IRoom;
    public function getUserEntities(): array;

    public function getLogger(): Logger;
    public function getNextEntityId(): int;

    public function getProcessComponent(): ProcessComponent;
    public function getMappingComponent(): MappingComponent;
}