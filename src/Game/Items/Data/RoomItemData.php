<?php

namespace Emulator\Game\Items\Data;

use Throwable;
use Emulator\Game\Items\ItemManager;
use Emulator\Api\Game\Items\Data\IRoomItemData;

class RoomItemData implements IRoomItemData
{
    private int $id;
    private int $ownerId;
    private string $ownerName;
    private int $roomId;
    private int $itemDefinitionId;
    private string $wallPosition;
    private int $x;
    private int $y;
    private float $z;
    private int $rotation;
    private string $extraData;
    private string $wiredData;
    private string $limitedData;
    private int $groupId;
    private int $limitedStack = 0;
    private int $limitedSells = 0;

    public function __construct(array &$data)
    {
        try {
            $this->id = $data['id'];
            $this->ownerId = $data['user_id'];
            $this->ownerName = $data['owner_name'];
            $this->roomId = $data['room_id'];
            $this->itemDefinitionId = $data['item_id'];
            $this->wallPosition = $data['wall_pos'];
            $this->x = $data['x'];
            $this->y = $data['y'];
            $this->z = (float) $data['z'];
            $this->rotation = $data['rot'];
            $this->extraData = !empty($data['extra_data']) ? $data['extra_data'] : "0";
            $this->wiredData = $data['wired_data'];
            $this->groupId = $data['guild_id'];

            if(!empty($data['limited_data'])) {
                $this->limitedStack = explode(':', $data['limited_data'])[0];
                $this->limitedSells = explode(':', $data['limited_data'])[1];
            }
        } catch (Throwable $error) {
            ItemManager::getInstance()->getLogger()->error("Failed to load room item data: Item ID #{$data['id']} in room ID #{$data['room_id']}. Error: {$error->getMessage()}");
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getOwnerName(): string
    {
        return $this->ownerName;
    }

    public function getRoomId(): int
    {
        return $this->roomId;
    }

    public function getItemDefinitionId(): int
    {
        return $this->itemDefinitionId;
    }

    public function getWallPosition(): string
    {
        return $this->wallPosition;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getZ(): float
    {
        return $this->z;
    }

    public function getRotation(): int
    {
        return $this->rotation;
    }

    public function getExtraData(): string
    {
        return $this->extraData;
    }

    public function getWiredData(): string
    {
        return $this->wiredData;
    }

    public function getLimitedData(): string
    {
        return $this->limitedData;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function getLimitedStack(): int
    {
        return $this->limitedStack;
    }

    public function getLimitedSells(): int
    {
        return $this->limitedSells;
    }

    public function isLimitedEdition(): bool
    {
        return $this->limitedStack > 0;
    }
}