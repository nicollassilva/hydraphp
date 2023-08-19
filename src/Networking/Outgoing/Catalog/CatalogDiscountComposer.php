<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;
use Emulator\Game\Catalog\Utils\CatalogDiscountData;

class CatalogDiscountComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$catalogDiscountComposer;

        $this->writeInt(CatalogDiscountData::$maximumAllowedItems);
        $this->writeInt(CatalogDiscountData::$discountBatchSize);
        $this->writeInt(CatalogDiscountData::$discountAmountPerBatch);
        $this->writeInt(CatalogDiscountData::$minimumDiscountForBonus);

        $this->writeInt(count(CatalogDiscountData::$additionalDiscountThresholds));

        foreach (CatalogDiscountData::$additionalDiscountThresholds as $threshold) {
            $this->writeInt($threshold);
        }
    }
}