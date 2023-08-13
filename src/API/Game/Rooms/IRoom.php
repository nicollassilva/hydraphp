<?php

namespace Emulator\Api\Game\Rooms;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Utilities\IComposable;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Rooms\Data\{IRoomData,IRoomModel};
use Emulator\Game\Rooms\Components\{MappingComponent,ProcessComponent,EntityComponent};

interface IRoom extends IComposable
{
    public function getData(): IRoomData;
    public function getModel(): IRoomModel;

    public function isOwner(IUser $user): bool;

    public function broadcastMessage(IMessageComposer $message): IRoom;

    public function getLogger(): Logger;
    public function getNextEntityId(): int;

    public function getProcessComponent(): ProcessComponent;
    public function getMappingComponent(): MappingComponent;
    public function getEntityComponent(): EntityComponent;

    public function dispose(): void;
    public function onIdleCycleChanged(): void;

    public function onUserEntityRemoved(UserEntity $entity): void;
    public function resetIdleCycle(): void;
}