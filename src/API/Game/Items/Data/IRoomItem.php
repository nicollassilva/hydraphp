<?php

namespace Emulator\Api\Game\Items\Data;

use Emulator\Api\Game\Utilities\IComposable;
use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Items\Data\{IItemDefinition,IRoomItemData};
use Emulator\Api\Game\Rooms\Types\Entities\IUserEntity;

interface IRoomItem extends IComposable
{
    public function getData(): IRoomItemData;
    public function onInteract(IUserEntity $entity, int $state): void;
    public function getItemDefinition(): ?IItemDefinition;
    public function composeExtraData(IMessageComposer $message): void;
}