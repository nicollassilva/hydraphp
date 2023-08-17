<?php

namespace Emulator\Api\Game\Items\Data;

interface IRoomFloorItem
{
    public function onEntityStepOn(): void;
}