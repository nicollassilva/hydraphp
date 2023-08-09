<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class CatalogDiscountComposer extends MessageComposer
{
    private int $maximumAllowedItems = 100;
    private int $discountBatchSize = 6;
    private int $discountAmountPerBatch = 1;
    private int $minimumDiscountForBonus = 1;

    public function __construct()
    {
        $this->header = OutgoingHeaders::$catalogDiscountComposer;

        $this->writeInt($this->maximumAllowedItems);
        $this->writeInt($this->discountBatchSize);
        $this->writeInt($this->discountAmountPerBatch);
        $this->writeInt($this->minimumDiscountForBonus);
        $this->writeInt(0);
    }
}