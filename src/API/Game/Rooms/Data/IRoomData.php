<?php

namespace Emulator\Api\Game\Rooms\Data;

interface IRoomData
{
    public function getId(): int;
    public function getName(): string;
    public function getDescription(): string;
    public function getOwnerId(): int;
    public function getOwner(): string;
    public function getMaxUsers(): int;
    public function getScore(): int;
}