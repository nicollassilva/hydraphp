<?php

namespace Emulator\Game\Catalog\Utils;

abstract class CatalogDiscountData
{
    public static int $maximumAllowedItems = 100;
    public static int $discountBatchSize = 6;
    public static int $discountAmountPerBatch = 1;
    public static int $minimumDiscountForBonus = 1;
    public static array $additionalDiscountThresholds = [40, 99];
}