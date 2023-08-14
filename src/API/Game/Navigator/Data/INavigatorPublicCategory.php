<?php

namespace Emulator\Api\Game\Navigator\Data;

use ArrayObject;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Navigator\Enums\NavigatorListMode;

interface INavigatorPublicCategory
{
    public function getId(): int;
    public function getName(): string;
    public function getListMode(): NavigatorListMode;
    public function getOrder(): int;

    public function addRoom(IRoom &$room): void;
    
    /** @return ArrayObject<int,IRoom> */
    public function getRooms(): ArrayObject;
}