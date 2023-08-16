<?php

namespace Emulator\Game\Items\Data;

use Emulator\Api\Game\Items\Data\IItemDefinition;
use Emulator\Game\Items\Enums\ItemDefinitionType;

class ItemDefinition implements IItemDefinition
{
    private readonly int $id;
    private readonly int $spriteId;
    private readonly string $publicName;
    private readonly string $itemName;
    private readonly ItemDefinitionType $type;
    private readonly int $width;
    private readonly int $length;
    private readonly float $stackHeight;
    private readonly bool $allowStack;
    private readonly bool $allowSit;
    private readonly bool $allowLay;
    private readonly bool $allowWalk;
    private readonly bool $allowTrade;
    private readonly bool $allowRecycle;
    private readonly bool $allowMarketplaceSell;
    private readonly bool $allowInventoryStack;
    private readonly string $interactionType;
    private readonly int $interactionModesCount;
    private readonly string $customParams;
    private readonly int $maleEffect;
    private readonly int $femaleEffect;
    private readonly string $clothingOnWalk;

    /** @var array<string> */
    private readonly array $vendingIds;

    /** @var array<float> */
    private readonly array $multiHeights;

    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->spriteId = $data['sprite_id'];
        $this->publicName = $data['public_name'];
        $this->itemName = $data['item_name'];
        $this->width = $data['width'];
        $this->length = $data['length'];
        $this->stackHeight = (float) $data['stack_height'];
        $this->allowStack = (bool) $data['allow_stack'];
        $this->allowSit = (bool) $data['allow_sit'];
        $this->allowLay = (bool) $data['allow_lay'];
        $this->allowWalk = (bool) $data['allow_walk'];
        $this->allowTrade = (bool) $data['allow_trade'];
        $this->allowRecycle = (bool) $data['allow_recycle'];
        $this->allowMarketplaceSell = (bool) $data['allow_marketplace_sell'];
        $this->allowInventoryStack = (bool) $data['allow_inventory_stack'];
        $this->interactionType = $data['interaction_type'];
        $this->interactionModesCount = $data['interaction_modes_count'];
        $this->customParams = $data['customparams'];
        $this->maleEffect = $data['effect_id_male'];
        $this->femaleEffect = $data['effect_id_female'];
        $this->clothingOnWalk = $data['clothing_on_walk'];
        
        try {
            $this->type = ItemDefinitionType::from($data['type']);
        } catch (\Throwable) {
            $this->type = ItemDefinitionType::Floor;
        }

        if(!! strlen($data['vending_ids'])) {
            $this->vendingIds = explode(',', str_replace(';', ',', $data['vending_ids']));
        } else {
            $this->vendingIds = [];
        }

        if(str_contains($data['multiheight'], ';')) {
            $this->multiHeights = explode(';', $data['multiheight']);
        } else {
            $this->multiHeights = [];
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSpriteId(): int
    {
        return $this->spriteId;
    }

    public function getPublicName(): string
    {
        return $this->publicName;
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function getType(): ItemDefinitionType
    {
        return $this->type;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getStackHeight(): float
    {
        return $this->stackHeight;
    }

    public function isAllowStack(): bool
    {
        return $this->allowStack;
    }

    public function isAllowSit(): bool
    {
        return $this->allowSit;
    }

    public function isAllowLay(): bool
    {
        return $this->allowLay;
    }
    
    public function isAllowWalk(): bool
    {
        return $this->allowWalk;
    }

    public function isAllowTrade(): bool
    {
        return $this->allowTrade;
    }

    public function isAllowRecycle(): bool
    {
        return $this->allowRecycle;
    }

    public function isAllowMarketplaceSell(): bool
    {
        return $this->allowMarketplaceSell;
    }

    public function isAllowInventoryStack(): bool
    {
        return $this->allowInventoryStack;
    }

    public function getInteractionType(): string
    {
        return $this->interactionType;
    }

    public function getInteractionModesCount(): int
    {
        return $this->interactionModesCount;
    }

    public function getCustomParams(): string
    {
        return $this->customParams;
    }

    public function getMaleEffect(): int
    {
        return $this->maleEffect;
    }

    public function getFemaleEffect(): int
    {
        return $this->femaleEffect;
    }

    public function getClothingOnWalk(): string
    {
        return $this->clothingOnWalk;
    }

    public function getVendingIds(): array
    {
        return $this->vendingIds;
    }

    public function getMultiHeights(): array
    {
        return $this->multiHeights;
    }

    public function isDecorationItem(): bool
    {
        return str_contains($this->getItemName(), 'wallpaper_single')
            || str_contains($this->getItemName(), 'floor_single')
            || str_contains($this->getItemName(), 'landscape_single');
    }
}