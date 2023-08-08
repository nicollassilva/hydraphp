<?php

namespace Emulator\Game\Utilities;

class Position
{
    public CONST NORTH = 0;
    public CONST NORTH_EAST = 1;
    public CONST EAST = 2;
    public CONST SOUTH_EAST = 3;
    public CONST SOUTH = 4;
    public CONST SOUTH_WEST = 5;
    public CONST WEST = 6;
    public CONST NORTH_WEST = 7;

    private int $x;
    private int $y;
    private int $z;

    public function __construct(int $x, int $y, int $z = 0)
    {
        $this->setX($x);
        $this->setY($y);
        $this->setZ($z);
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }

    public function getZ(): int
    {
        return $this->z;
    }

    public function setZ(int $z): void
    {
        $this->z = $z;
    }

    public function add(Position $otherPosition): Position
    {
        return new Position($this->getX() + $otherPosition->getX(), $this->getY() + $otherPosition->getY(), $this->getZ() + $otherPosition->getZ());
    }

    public function isEquals(Position $positionToCompare): bool
    {
        return $this->getX() == $positionToCompare->getX() && $this->getY() == $positionToCompare->getY();
    }

    public function calculateRotation(Position $newPosition): int
    {
        return match (true) {
            $this->getX() > $newPosition->getX() && $this->getY() > $newPosition->getY() => self::NORTH_WEST,
            $this->getX() < $newPosition->getX() && $this->getY() < $newPosition->getY() => self::SOUTH_EAST,
            $this->getX() > $newPosition->getX() && $this->getY() < $newPosition->getY() => self::SOUTH_WEST,
            $this->getX() < $newPosition->getX() && $this->getY() > $newPosition->getY() => self::NORTH_EAST,
            $this->getX() > $newPosition->getX() => self::WEST,
            $this->getX() < $newPosition->getX() => self::EAST,
            $this->getY() < $newPosition->getY() => self::SOUTH,
            $this->getY() > $newPosition->getY() => self::NORTH,
            default => self::NORTH
        };
    }

    public function getDistanceTo(Position $position): int
    {
        $distanceX = abs($this->getX() - $position->getX());
        $distanceY = abs($this->getY() - $position->getY());

        return ($distanceX * $distanceX) + ($distanceY * $distanceY);
    }
}