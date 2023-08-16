<?php

namespace Emulator\Api\Game\Catalog\Data;

use Emulator\Api\Game\Utilities\IComposable;
use Emulator\Api\Game\Items\Data\IItemDefinition;

interface ICatalogItem extends IComposable
{
    public function getId(): int;
    public function getItemIds(): array;
    public function getPageId(): int;
    public function getCatalogName(): string;
    public function getCostCredits(): int;
    public function getCostPoints(): int;
    public function getPointsType(): int;
    public function getAmount(): int;
    public function getLimitedStack(): int;
    public function getLimitedSells(): int;
    public function getOrderNumber(): int;
    public function getOfferId(): int;
    public function getSongId(): int;
    public function getExtraData(): string;
    public function haveOffer(): bool;
    public function isClubOnly(): bool;
    public function isLimited(): bool;
    public function checkHaveOffer(): bool;

    /** @return array<int,IItemDefinition> */
    public function getItemsDefinitions(): array;
}