<?php

namespace Emulator\Api\Game\Rooms\Data;

use Emulator\Game\Rooms\Enums\RoomState;
use Emulator\Api\Game\Navigator\Data\INavigatorCategory;

interface IRoomData
{
    public function getId(): int;
    public function getName(): string;
    public function getDescription(): string;
    public function getModel(): string;
    public function getOwnerId(): int;
    public function getOwnerName(): string;
    public function getMaxUsers(): int;
    public function getScore(): int;
    public function getPassword(): string;
    public function getState(): ?RoomState;
    public function getGuildId(): int;
    public function getCategoryId(): string;
    public function getCategory(): ?INavigatorCategory;
    public function getPaperFloor(): string;
    public function getPaperWall(): string;
    public function getPaperLandscape(): string;
    public function getThicknessWall(): int;
    public function getWallHeight(): int;
    public function getThicknessFloor(): int;
    public function getMoodlightData(): string;
    public function getTags(): array;
    public function isPublic(): bool;
    public function setIsPublic(bool $isPublic): void;
    public function isStaffPicked(): bool;
    public function allowPets(): bool;
    public function allowPetsEat(): bool;
    public function allowWalkthrough(): bool;
    public function isHideWall(): bool;
    public function getChatMode(): int;
    public function getChatWeight(): int;
    public function getChatSpeed(): int;
    public function getChatDistance(): int;
    public function getChatProtection(): int;
    public function overrideModel(): bool;
    public function getWhoCanMute(): int;
    public function getWhoCanKick(): int;
    public function getWhoCanBan(): int;
    public function getPollId(): int;
    public function getRollerSpeed(): int;
    public function isPromoted(): bool;
    public function getTradeMode(): int;
    public function canMoveDiagonally(): bool;
    public function hasJukeboxActive(): bool;
    public function hideWireds(): bool;
    public function isForSale(): bool;
}