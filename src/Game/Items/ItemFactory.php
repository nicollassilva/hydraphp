<?php

namespace Emulator\Game\Items;

use ArrayObject;
use Emulator\Utils\Logger;

class ItemFactory
{
    public static ?ItemFactory $instance = null;

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
        // $this->itemsInteractions->offsetSet('vendingmachine', new VendingMachineInteraction());
    }
}