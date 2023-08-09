<?php

namespace Emulator\Game\Catalog\Data;

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
    private readonly int $minRank;
    private int $orderNum;
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

    /** @var array<int,CatalogPage> */	
    private array $childPages = [];

    public function __construct(array &$data)
    {
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

        if(empty($data['includes'])) {
            $this->includes = [];
        } else {
            $this->includes = explode(';', $data['includes']);
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

    public function getItems(): array
    {
        return [];
    }

    public function addChildPage(ICatalogPage $childPage): void
    {
        $this->childPages[$childPage->getId()] = $childPage;

        if($childPage->getMinRank() < $this->getMinRank()) {
            $childPage->setMinRank($this->getMinRank());
        }
    }

    /** @return array<int,ICatalogPage> */
    public function getChildPages(): array
    {
        return $this->childPages;
    }

    public function setMinRank(int $rank): void
    {
        $this->minRank = $rank;
    }
}