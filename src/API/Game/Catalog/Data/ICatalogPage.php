<?php

namespace Emulator\Api\Game\Catalog\Data;

use Emulator\Api\Game\Catalog\Data\ICatalogItem;

interface ICatalogPage
{
    public function getId(): int;
    public function getParentId(): int;
    public function getCaptionSave(): string;
    public function getCaption(): string;
    public function getPageLayout(): string;
    public function getIconColor(): int;
    public function getIconImage(): int;
    public function getMinRank(): int;
    public function getOrderNum(): int;
    public function isVisible(): bool;
    public function isEnabled(): bool;
    public function isClubOnly(): bool;
    public function isVipOnly(): bool;
    public function getPageHeadline(): ?string;
    public function getPageTeaser(): ?string;
    public function getPageSpecial(): ?string;
    public function getPageText1(): ?string;
    public function getPageText2(): ?string;
    public function getPageTextDetails(): ?string;
    public function getPageTextTeaser(): ?string;
    public function getRoomId(): int;
    public function getIncludes(): array;

    public function addChildPage(ICatalogPage $childPage): void;
    public function getChildPages(): array;
    public function setMinRank(int $rank): void;

    public function addItem(ICatalogItem $item): void;
    public function getItemById(int $id): ?ICatalogItem;
    public function getItems(): array;

    /** @return array<int,ICatalogItem> */
    public function getOrderedItems(): array;
}