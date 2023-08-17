<?php

namespace Emulator\Game\Items;

use ArrayObject;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Items\Data\IRoomItem;
use Emulator\Game\Items\Enums\ItemDefinitionType;
use Emulator\Game\Items\Interactions\Wall\DefaultWallItem;
use Emulator\Game\Items\Interactions\Floor\DefaultFloorItem;

class ItemFactory
{
    public static ?ItemFactory $instance = null;

    /** 
     * @property ArrayObject<string,string>
     */
    private ArrayObject $itemsInteractions;

    private readonly Logger $logger;

    private bool $isStarted = false;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));

        $this->itemsInteractions = new ArrayObject();
    }

    public static function getInstance(): ItemFactory
    {
        if(!(self::$instance instanceof ItemFactory)) self::$instance = new ItemFactory();

        return self::$instance;
    }

    public function initialize(): void
    {
        if ($this->isStarted) return;

        $this->isStarted = true;

        $this->registerItemsInteractions();

        $this->logger->info("ItemFactory initialized.");
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function registerItemsInteractions(): void
    {
        $this->itemsInteractions->offsetSet('default_floor', DefaultFloorItem::class);
        $this->itemsInteractions->offsetSet('default_wall', DefaultWallItem::class);
    }

    public function getItemInteractionClassName(string $interaction): string
    {
        if($this->itemsInteractions->offsetExists($interaction)) {
            return $this->itemsInteractions->offsetGet($interaction);
        }

        return $this->itemsInteractions->offsetGet('default');
    }

    public function createItemFromQueryResult(array &$data, IRoom &$room, ItemDefinitionType $itemDefinitionType): ?IRoomItem
    {
        if($itemDefinitionType === ItemDefinitionType::Floor) {
            return $this->createFloorItemFromQueryResult($data, $room);
        }

        if($itemDefinitionType === ItemDefinitionType::Wall) {
            return $this->createWallItemFromQueryResult($data, $room);
        }

        return null;
    }

    public function createFloorItemFromQueryResult(array &$data, IRoom $room): ?IRoomItem
    {
        $className = $this->getItemInteractionClassName('default_floor');

        if(!$className) return null;

        return new $className($data, $room);
    }

    public function createWallItemFromQueryResult(array &$data, IRoom $room): ?IRoomItem
    {
        $className = $this->getItemInteractionClassName('default_wall');

        if(!$className) return null;

        return new $className($data, $room);
    }
}