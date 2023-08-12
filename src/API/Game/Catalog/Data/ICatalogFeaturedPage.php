<?php

namespace Emulator\Api\Game\Catalog\Data;

use Emulator\Api\Game\Utilities\IComposable;
use Emulator\Game\Catalog\Enums\CatalogFeaturedPageType;

interface ICatalogFeaturedPage extends IComposable
{
    public function getSlotId(): int;
    public function getCaption(): string;
    public function getImage(): string;
    public function getExpireTimestamp(): int;
    public function getType(): CatalogFeaturedPageType;
    public function getPageName(): string;
    public function getPageId(): int;
    public function getProductName(): string;
}