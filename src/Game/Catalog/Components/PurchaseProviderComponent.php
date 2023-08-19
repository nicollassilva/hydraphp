<?php

namespace Emulator\Game\Catalog\Components;

use ArrayObject;
use Emulator\Api\Game\Catalog\Providers\IPurchaseProvider;
use Emulator\Game\Catalog\Providers\DefaultPurchaseProvider;

class PurchaseProviderComponent
{
    /** @var ArrayObject<string,IPurchaseProvider> $purchaseProviders */
    private ArrayObject $purchaseProviders;

    public function __construct()
    {
        $this->registerProviders();
    }

    public function getProviderByItemInteraction(string $interactionType): ?IPurchaseProvider
    {
        if(!$this->purchaseProviders->offsetExists($interactionType)) return null;

        return $this->purchaseProviders->offsetGet($interactionType);
    }

    private function registerProviders(): void
    {
        $this->purchaseProviders = new ArrayObject([
            'default' => new DefaultPurchaseProvider()
        ]);
    }
}