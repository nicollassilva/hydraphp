<?php

namespace Emulator\Game\Rooms\Data;

use Emulator\Api\Game\Rooms\Data\IRoomModel;
use Emulator\Game\Rooms\Enums\RoomTileState;
use Emulator\Game\Utilities\Position;

class RoomModel implements IRoomModel
{
    public CONST BASIC_MOVEMENT_COST = 10;
    public CONST DIAGONAL_MOVEMENT_COST = 14;

    private string $name;

    private int $doorX;
    private int $doorY;
    private int $doorZ;
    private int $doorDirection;

    private string $heightmap;

    private int $mapSize;
    private int $mapSizeX;
    private int $mapSizeY;

    // @param RoomTile[][]
    private array $roomTiles = [];

    private RoomTile $doorTile;

    public function __construct(array &$data)
    {
        $this->name = $data['name'];

        $this->doorX = $data['door_x'];
        $this->doorY = $data['door_y'];
        $this->doorZ = 0;
        $this->doorDirection = $data['door_dir'];

        $this->heightmap = $data['heightmap'];

        $this->calculateModel();
    }

    private function calculateModel(): void
    {
        $temporaryModel = explode("\r", str_replace("\n", "", $this->heightmap));

        $this->mapSize = 0;
        $this->mapSizeX = strlen($temporaryModel[0]);
        $this->mapSizeY = count($temporaryModel);
        
        $positionZero = new Position(0, 0, 0);

        for ($x = 0; $x < $this->mapSizeX; $x++) {
            for ($y = 0; $y < $this->mapSizeY; $y++) {
                $this->roomTiles[$x][$y] = new RoomTile($positionZero);
            }
        }

        for ($y = 0; $y < $this->mapSizeY; $y++) {
            if(empty($temporaryModel[$y]) || $temporaryModel[$y] == "\r") continue;

            for($x = 0; $x < $this->mapSizeX; $x++) {
                if(strlen($temporaryModel[$y]) != $this->mapSizeX) break;

                $squareType = strtolower(trim(substr($temporaryModel[$y], $x, $x + 1)));
                $tileState = RoomTileState::Open;
                $tileHeight = 0;

                if($squareType == 'x') {
                    $tileState = RoomTileState::Invalid;
                } else {
                    if(empty($squareType)) {
                        $tileHeight = 0;
                    } else if(is_numeric($squareType)) {
                        $tileHeight = (int) $squareType;
                    } else {
                        $tileHeight = (10 + strpos("ABCDEFGHIJKLMNOPQRSTUVWXYZ", $squareType));
                    }
                }

                $this->mapSize += 1;

                $this->roomTiles[$x][$y] = new RoomTile(new Position($x, $y, $tileHeight), $tileState);
            }
        }

        $this->doorTile = $this->roomTiles[$this->doorX][$this->doorY];

        if(empty($this->getDoorTile())) return;

        $this->getDoorTile()->setCanStack(false);

        $frontalTile = $this->getFrontTile($this->getDoorTile(), $this->doorDirection, 0);

        if(empty($frontalTile) || $this->tileExists($frontalTile->getPosition()->getX(), $frontalTile->getPosition()->getY())) return;

        if($frontalTile->getState() == RoomTileState::Invalid) return;

        if($this->getDoorZ() == $frontalTile->getPosition()->getZ() || $this->getDoorTile()->getState() == $frontalTile->getState()) return;

        $this->setDoorZ($frontalTile->getPosition()->getZ());
        $frontalTile->setState(RoomTileState::Open);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDoorTile(): RoomTile
    {
        return $this->doorTile;
    }

    public function getDoorDirection(): int
    {
        return $this->doorDirection;
    }

    public function getDoorZ(): int
    {
        return $this->doorZ;
    }

    public function setDoorZ(int $doorZ): void
    {
        $this->doorZ = $doorZ;
    }

    public function getFrontTile(RoomTile $tile, int $rotation, int $offset): ?RoomTile
    {
        $offsetX = 0;
        $offsetY = 0;

        $rotation %= 8;

        match ($rotation) {
            0 => $offsetY--,
            1 => function() use (&$offsetX, &$offsetY) {
                $offsetX++;
                $offsetY--;
            },
            2 => $offsetX++,
            3 => function() use (&$offsetX, &$offsetY) {
                $offsetX++;
                $offsetY++;
            },
            4 => $offsetY++,
            5 => function() use (&$offsetX, &$offsetY) {
                $offsetX--;
                $offsetY++;
            },
            6 => $offsetX--,
            7 => function() use (&$offsetX, &$offsetY) {
                $offsetX--;
                $offsetY--;
            }
        };

        $x = $tile->getPosition()->getX() + ($offsetX * $offset);
        $y = $tile->getPosition()->getY() + ($offsetY * $offset);

        return $this->getTile($x, $y);
    }

    public function getTile(int $x, int $y): ?RoomTile
    {
        return $this->roomTiles[$x][$y] ?? null;
    }

    public function tileExists(int $x, int $y): bool
    {
        return !($x < 0 || $y < 0 || $x >= $this->getMapSizeX() || $y >= $this->getMapSizeY());
    }

    public function getRelativeMap(): string
    {
        return str_replace("\r\n", "\r", $this->heightmap);
    }

    public function getMapSizeX(): int
    {
        return $this->mapSizeX;
    }

    public function getMapSizeY(): int
    {
        return $this->mapSizeY;
    }

    public function getMapSize(): int
    {
        return $this->mapSize;
    }
}