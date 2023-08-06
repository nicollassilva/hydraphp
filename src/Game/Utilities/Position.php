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

    public function __construct(int $x, int $y, int $z)
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
}