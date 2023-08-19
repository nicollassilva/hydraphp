<?php

namespace Emulator\Game\Catalog\Data;

use ArrayObject;
use Emulator\Game\Catalog\CatalogManager;
use Emulator\Api\Game\Catalog\Data\ICatalogItem;
use Emulator\Api\Game\Catalog\Data\ICatalogPage;

class CatalogPage implements ICatalogPage
{
    private readonly int $id;
    private readonly int $parentId;
    
    private readonly string $captionSave;
    private readonly string $caption;
    
    private readonly string $pageLayout;
    private readonly int $iconColor;
    private readonly int $iconImage;
    private int $minRank;
    private readonly int $orderNum;
    private readonly bool $isVisible;
    private readonly bool $isEnabled;
    private readonly bool $isClubOnly;
    private readonly bool $isVipOnly;

    private readonly ?string $pageHeadline;
    private readonly ?string $pageTeaser;
    private readonly ?string $pageSpecial;
    private readonly ?string $pageText1;
    private readonly ?string $pageText2;
    private readonly ?string $pageTextDetails;
    private readonly ?string $pageTextTeaser;

    private readonly int $roomId;

    private readonly array $includes;

    /** @var ArrayObject<int,ICatalogItem> */
    private ArrayObject $items;

    /** @var ArrayObject<int,CatalogPage> */	
    private ArrayObject $childPages;

    public function __construct(array &$data)
    {
        try {
            $this->id = (int) $data['id'];
            $this->parentId = (int) $data['parent_id'];
            
            $this->captionSave = $data['caption_save'];
            $this->caption = $data['caption'];
            
            $this->pageLayout = $data['page_layout'] ?? '';
            $this->iconColor = (int) $data['icon_color'];
            $this->iconImage = (int) $data['icon_image'];
            $this->minRank = (int) $data['min_rank'];
            $this->orderNum = (int) $data['order_num'];
            $this->isVisible = (bool) $data['visible'];
            $this->isEnabled = (bool) $data['enabled'];
            $this->isClubOnly = (bool) ($data['club_only'] ?? false);
            $this->isVipOnly = (bool) ($data['vip_only'] ?? false);

            $this->pageHeadline = $data['page_headline'] ?? '';
            $this->pageTeaser = $data['page_teaser'] ?? '';
            $this->pageSpecial = $data['page_special'] ?? '';
            $this->pageText1 = $data['page_text1'] ?? '';
            $this->pageText2 = $data['page_text2'] ?? '';
            $this->pageTextDetails = $data['page_text_details'] ?? '';
            $this->pageTextTeaser = $data['page_text_teaser'] ?? '';

            $this->roomId = $data['room_id'] ?? 0;
            $this->childPages = new ArrayObject;

            if(empty($data['includes'])) {
                $this->includes = [];
            } else {
                $this->includes = explode(';', $data['includes']);
            }

            $this->items = new ArrayObject;
        } catch (\Throwable $error) {
            CatalogManager::getInstance()->getLogger()->error('Error while constructing a catalog page: ' . $error->getMessage());
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }

    public function getCaptionSave(): string
    {
        return $this->captionSave;
    }

    public function getCaption(): string
    {
        return $this->caption;
    }

    public function getPageLayout(): string
    {
        return $this->pageLayout;
    }

    public function getLayoutHandler(): ?string
    {
        return CatalogManager::getInstance()->getLayoutComponent()->getByName($this->getPageLayout());
    }

    public function getIconColor(): int
    {
        return $this->iconColor;
    }

    public function getIconImage(): int
    {
        return $this->iconImage;
    }

    public function getMinRank(): int
    {
        return $this->minRank;
    }

    public function getOrderNum(): int
    {
        return $this->orderNum;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function isClubOnly(): bool
    {
        return $this->isClubOnly;
    }

    public function isVipOnly(): bool
    {
        return $this->isVipOnly;
    }

    public function getPageHeadline(): ?string
    {
        return $this->pageHeadline;
    }

    public function getPageTeaser(): ?string
    {
        return $this->pageTeaser;
    }

    public function getPageSpecial(): ?string
    {
        return $this->pageSpecial;
    }

    public function getPageText1(): ?string
    {
        return $this->pageText1;
    }

    public function getPageText2(): ?string
    {
        return $this->pageText2;
    }

    public function getPageTextDetails(): ?string
    {
        return $this->pageTextDetails;
    }

    public function getPageTextTeaser(): ?string
    {
        return $this->pageTextTeaser;
    }

    public function getRoomId(): int
    {
        return $this->roomId;
    }

    public function getIncludes(): array
    {
        return $this->includes;
    }

    public function addChildPage(ICatalogPage &$childPage): void
    {
        if($this->childPages->offsetExists($childPage->getId())) return;

        $this->childPages->offsetSet($childPage->getId(), $childPage);

        if($childPage->getMinRank() < $this->getMinRank()) {
            $childPage->setMinRank($this->getMinRank());
        }
    }

    /** @return ArrayObject<int,ICatalogPage> */
    public function getChildPages(): ArrayObject
    {
        return $this->childPages;
    }

    public function setMinRank(int $rank): void
    {
        $this->minRank = $rank;
    }

    public function addItem(ICatalogItem $item): void
    {
        $this->items->offsetSet($item->getId(), $item);
    }

    public function hasItem(int $itemId): bool
    {
        return $this->items->offsetExists($itemId);
    }

    public function getItemById(int $id): ?ICatalogItem
    {
        return $this->items->offsetGet($id) ?? null;
    }

    /** @return ArrayObject<int,ICatalogItem> */
    public function getItems(): ArrayObject
    {
        return $this->items;
    }

    /** @return array<int,ICatalogItem> */
    public function getOrderedItems(): array
    {
        $items = $this->getItems()->getArrayCopy();

        usort($items,
            fn(ICatalogItem $a, ICatalogItem $b) => $a->getId() <=> $b->getId()
        );

        return $items;
    }
}