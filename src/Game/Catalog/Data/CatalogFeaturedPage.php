<?php

namespace Emulator\Game\Catalog\Data;

use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Catalog\Data\ICatalogFeaturedPage;
use Emulator\Game\Catalog\Enums\CatalogFeaturedPageType;

class CatalogFeaturedPage implements ICatalogFeaturedPage
{
    private readonly int $slotId;
    private readonly string $caption;
    private readonly string $image;
    private readonly int $expireTimestamp;
    private readonly CatalogFeaturedPageType $type;
    private readonly string $pageName;
    private readonly int $pageId;
    private readonly string $productName;

    public function __construct(array $data)
    {
        $this->slotId = (int) $data["slot_id"];
        $this->caption = $data["caption"];
        $this->image = $data["image"];
        $this->expireTimestamp = (int) $data["expire_timestamp"];
        $this->type = CatalogFeaturedPageType::from((int) $data['type']);
        $this->pageName = $data["page_name"];
        $this->pageId = (int) $data["page_id"];
        $this->productName = $data["product_name"];
    }

    public function getSlotId(): int
    {
        return $this->slotId;
    }

    public function getCaption(): string
    {
        return $this->caption;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getExpireTimestamp(): int
    {
        return $this->expireTimestamp;
    }

    public function getType(): CatalogFeaturedPageType
    {
        return $this->type;
    }

    public function getPageName(): string
    {
        return $this->pageName;
    }

    public function getPageId(): int
    {
        return $this->pageId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function compose(IMessageComposer $message): void
    {
        $message->writeInt($this->slotId);
        $message->writeString($this->caption);
        $message->writeString($this->image);
        $message->writeInt($this->type->value);

        switch($this->type) {
            case CatalogFeaturedPageType::PageName:
                $message->writeString($this->pageName);
                break;
            case CatalogFeaturedPageType::PageId:
                $message->writeInt($this->pageId);
                break;
            case CatalogFeaturedPageType::ProductName:
                $message->writeString($this->productName);
                break;
        }

        $message->writeInt(time() - $this->expireTimestamp);
    }
}