<?php

namespace Emulator\Game\Rooms\Data\RoomModel;

use Emulator\Game\Rooms\RoomManager;

class RoomModelData
{
    private readonly int $doorX;
    private readonly int $doorY;
    private readonly string $name;
    private readonly string $heightmap;
    private readonly int $doorDirection;

    private float $doorZ;

    public function __construct(array &$data)
    {
        try {
            $this->name = $data['name'];
            $this->heightmap = $data['heightmap'];

            $this->doorX = $data['door_x'];
            $this->doorY = $data['door_y'];
            $this->doorZ = 0;

            $this->doorDirection = $data['door_dir'];
        } catch (\Throwable $error) {
            RoomManager::getInstance()->getLogger()->error("Failed to parse room model [{$this->name}] data: " . $error->getMessage());
        }
    }

    public function setDoorZ(float $doorZ): void
    {
        $this->doorZ = $doorZ;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHeightmap(): string
    {
        return $this->heightmap;
    }

    public function getDoorX(): int
    {
        return $this->doorX;
    }

    public function getDoorY(): int
    {
        return $this->doorY;
    }

    public function getDoorZ(): float
    {
        return $this->doorZ;
    }

    public function getDoorDirection(): int
    {
        return $this->doorDirection;
    }

    public function getRelativeMap(): string
    {
        return str_replace("\r\n", "\r", $this->getHeightmap());
    }
}