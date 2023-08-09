<?php

namespace Emulator\Api\Game\Rooms\Data;

use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Data\RoomTile;
use Emulator\Game\Rooms\Data\RoomModel\RoomModelData;

interface IRoomModel
{
    public function getDoorTile(): RoomTile;
    public function getFrontTile(RoomTile $tile, int $rotation, int $offset): ?RoomTile;
    public function getTile(int $x, int $y): ?RoomTile;
    public function tileExists(int $x, int $y): bool;
    public function getMapSizeX(): int;
    public function getMapSizeY(): int;
    public function getMapSize(): int;
    public function getData(): RoomModelData;
    public function getTilesLength(): int;
    public function isValid(Position $position): bool;
    public function positionIsDoor(Position $position): bool;
    public function getTiles(?int $x = null): array;
    public function getTileForPathfinder(Position $current, Position $movePoint): ?RoomTile;
}