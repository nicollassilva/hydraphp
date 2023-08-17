<?php

namespace Emulator\Game\Items;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Items\IItemManager;
use Emulator\Api\Game\Items\Data\IItemDefinition;
use Emulator\Storage\Repositories\Items\ItemRepository;

class ItemManager implements IItemManager
{
    public static ItemManager $instance;

    private readonly Logger $logger;

    private bool $isStarted = false;

    /** @var array<int,IItemDefinition> */
    private array $itemsDefinitions = [];

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));
    }

    public static function getInstance(): IItemManager
    {
        if(!isset(self::$instance)) self::$instance = new ItemManager();

        return self::$instance;
    }

    public function initialize(): void
    {
        if ($this->isStarted) return;

        ItemRepository::loadItemDefinitions($this->itemsDefinitions);
        ItemFactory::getInstance()->initialize();

        $this->isStarted = true;

        $this->logger->info(sprintf("ItemManager initialized with %s items definitions.", count($this->itemsDefinitions)));
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function getItemDefinitionById(string|int $id): ?IItemDefinition
    {
        return $this->itemsDefinitions[$id] ?? null;
    }
}