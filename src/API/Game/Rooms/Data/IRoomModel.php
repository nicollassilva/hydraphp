<?php

namespace Emulator\Api\Game\Rooms\Data;

use Emulator\Game\Rooms\Data\RoomTile;

interface IRoomModel
{
    public function getDoorTile(): RoomTile;
    public function getDoorZ(): int;
    public function setDoorZ(int $doorZ): void;
    public function getFrontTile(RoomTile $tile, int $rotation, int $offset): ?RoomTile;
    public function getTile(int $x, int $y): ?RoomTile;
    public function tileExists(int $x, int $y): bool;
    public function getMapSizeX(): int;
    public function getMapSizeY(): int;
    public function getName(): string;
    public function getDoorDirection(): int;
}