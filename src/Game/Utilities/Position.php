<?php

namespace Emulator\Game\Utilities;

class Position
{
    public const NORTH = 0;
    public const NORTH_EAST = 1;
    public const EAST = 2;
    public const SOUTH_EAST = 3;
    public const SOUTH = 4;
    public const SOUTH_WEST = 5;
    public const WEST = 6;
    public const NORTH_WEST = 7;

    private int $x;
    private int $y;
    private float $z;

    public function __construct(int $x, int $y, float $z = 0)
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

    public function setY(float $y): void
    {
        $this->y = $y;
    }

    public function getZ(): float
    {
        return $this->z;
    }

    public function setZ(float $z): void
    {
        $this->z = $z;
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