<?php

namespace Emulator\Game\Rooms\Data;

use Emulator\Game\Rooms\RoomManager;
use Emulator\Game\Utilities\Position;
use Emulator\Api\Game\Rooms\Data\IRoomModel;
use Emulator\Game\Rooms\Enums\RoomTileState;
use Emulator\Game\Rooms\Data\RoomModel\RoomModelData;

class RoomModel implements IRoomModel
{
    public CONST BASIC_MOVEMENT_COST = 10;
    public CONST DIAGONAL_MOVEMENT_COST = 14;

    private RoomModelData $data;

    private int $mapSize;
    private int $mapSizeX;
    private int $mapSizeY;

    /** @var RoomTile[][] $roomTiles */
    private array $roomTiles = [];

    private RoomTile $doorTile;

    public function __construct(array &$data)
    {
        $this->data = new RoomModelData($data);

        try {
            $this->calculateModel();
        } catch (\Throwable $e) {
            RoomManager::getInstance()->getLogger()->error("Failed to parse room model [{$this->data->getName()}]: " . $e->getMessage());
        }
    }

    private function calculateModel(): void
    {
        $temporaryModel = explode("\r", str_replace("\n", "", $this->getData()->getHeightmap()));

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
            if(empty($temporaryModel[$y]) || strcasecmp($temporaryModel[$y], "\r") === 0) continue;

            for($x = 0; $x < $this->mapSizeX; $x++) {
                if(strlen($temporaryModel[$y]) != $this->mapSizeX) break;

                $squareType = strtolower(trim(substr($temporaryModel[$y], $x, 1)));
                $tileState = RoomTileState::Open;
                $tileHeight = 0;

                if(strcasecmp($squareType, 'x') === 0) {
                    $tileState = RoomTileState::Invalid;
                    continue;
                }

                if(is_numeric($squareType)) {
                    $tileHeight = (float) $squareType;
                } else {
                    $tileHeight = (float) 10 + strpos("abcdefghijklmnopqrstuvwxyz", $squareType, 1);
                }

                $this->mapSize += 1;

                $this->roomTiles[$x][$y] = new RoomTile(new Position($x, $y, $tileHeight), $tileState);
            }
        }

        $this->doorTile = $this->roomTiles[$this->getData()->getDoorX()][$this->getData()->getDoorY()];

        if(empty($this->getDoorTile())) return;
        
        $this->getDoorTile()->setCanStack(false);
        
        $frontalTile = $this->getFrontTile($this->getDoorTile(), $this->getData()->getDoorDirection(), 0);
        
        if(empty($frontalTile) || !$this->tileExists($frontalTile->getPosition()->getX(), $frontalTile->getPosition()->getY())) return;
        
        if($frontalTile->getState() == RoomTileState::Invalid) return;

        if($this->getData()->getDoorZ() == $frontalTile->getPosition()->getZ() || $this->getDoorTile()->getState() == $frontalTile->getState()) return;

        $this->getData()->setDoorZ($frontalTile->getPosition()->getZ());

        $frontalTile->setState(RoomTileState::Open);
    }

    public function getDoorTile(): RoomTile
    {
        return $this->doorTile;
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

    public function getTileHeight(int $x, int $y): float
    {
        return $this->roomTiles[$x][$y]->getPosition()->getZ();
    }

    public function getData(): RoomModelData
    {
        return $this->data;
    }

    public function getTilesLength(): int
    {
        return count($this->roomTiles);
    }

    public function isValid(Position $position): bool
    {
        return $this->tileExists($position->getX(), $position->getY())
            && !in_array($this->roomTiles[$position->getX()][$position->getY()]->getState(), [RoomTileState::Invalid, RoomTileState::Blocked]);
    }

    public function positionIsDoor(Position $position): bool
    {
        return $position->getX() == $this->getData()->getDoorX() && $position->getY() == $this->getData()->getDoorY();
    }

    public function getTiles(?int $x = null): array
    {
        if(is_numeric($x)) return $this->roomTiles[$x];

        return $this->roomTiles;
    }

    public function getTileForPathfinder(Position $current, Position $movePoint): ?RoomTile
    {
        return $this->getTile($current->getX() + $movePoint->getX(), $current->getY() + $movePoint->getY());
    }
}