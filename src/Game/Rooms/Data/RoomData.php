<?php

namespace Emulator\Game\Rooms\Data;

use Emulator\Api\Game\Rooms\Data\IRoomData;

class RoomData implements IRoomData
{
    private int $id;
    private string $name;
    private string $description;
    private int $ownerId;
    private string $owner;
    private int $maxUsers;
    private int $score;

    public function __construct(array $roomData = [])
    {
        print_r($roomData);
        $this->id = 1;
        $this->name = 'PHP Emulator Room';
        $this->description = 'PHP Emulator';
        $this->ownerId = 1;
        $this->owner = 'iNicollas';
        $this->maxUsers = 15;
        $this->score = 1;    
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getMaxUsers(): int
    {
        return $this->maxUsers;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}