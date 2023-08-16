<?php

namespace Emulator\Api\Game\Items\Data;

use Emulator\Game\Items\Enums\ItemDefinitionType;

interface IItemDefinition
{
    public function getId(): int;
    public function getSpriteId(): int;
    public function getPublicName(): string;
    public function getItemName(): string;
    public function getType(): ItemDefinitionType;
    public function getWidth(): int;
    public function getLength(): int;
    public function getStackHeight(): float;
    public function isAllowStack(): bool;
    public function isAllowSit(): bool;
    public function isAllowLay(): bool;
    public function isAllowWalk(): bool;
    public function isAllowTrade(): bool;
    public function isAllowRecycle(): bool;
    public function isAllowMarketplaceSell(): bool;
    public function isAllowInventoryStack(): bool;
    public function getInteractionType(): string;
    public function getInteractionModesCount(): int;
    public function getCustomParams(): string;
    public function getMaleEffect(): int;
    public function getFemaleEffect(): int;
    public function getClothingOnWalk(): string;
    public function isDecorationItem(): bool;

    /** @return array<string> */
    public function getVendingIds(): array;

    /** @return array<float> */
    public function getMultiHeights(): array;
}