<?php

namespace Emulator\Game\Navigator;

use ArrayObject;
use Emulator\Hydra;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Api\Game\Navigator\INavigatorManager;
use Emulator\Game\Navigator\Data\NavigatorFilterField;
use Emulator\Storage\Repositories\Navigator\NavigatorRepository;
use Emulator\Api\Game\Navigator\Data\{INavigatorCategory,INavigatorPublicCategory};

class NavigatorManager implements INavigatorManager
{
    public static NavigatorManager $instance;

    private readonly Logger $logger;

    private bool $isStarted = false;

    /** @var ArrayObject<int,INavigatorCategory> */
    private ArrayObject $flatCategories;

    /** @var ArrayObject<int,INavigatorPublicCategory> */
    private ArrayObject $publicCategories;

    /** @var ArrayObject<string,NavigatorFilterField> */
    private ArrayObject $filterSettings;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));

        $this->flatCategories = new ArrayObject;
        $this->publicCategories = new ArrayObject;
        $this->filterSettings = new ArrayObject;
    }

    public static function getInstance(): NavigatorManager
    {
        if (!isset(self::$instance)) self::$instance = new NavigatorManager();

        return self::$instance;
    }

    public function initialize(): void
    {
        if ($this->isStarted) return;

        $this->isStarted = true;

        NavigatorFilterManager::getInstance()->initialize();

        NavigatorRepository::loadNavigatorCategories($this->flatCategories);
        NavigatorRepository::loadNavigatorPublicCategories($this->publicCategories);
        NavigatorRepository::loadNavigatorFilterSettings($this->filterSettings);

        $this->logger->info("NavigatorManager initialized.");
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /** @return ArrayObject<int,INavigatorCategory> */
    public function getFlatCategories(): ArrayObject
    {
        return $this->flatCategories;
    }

    public function getFlatCategoryById(int|string $id): ?INavigatorCategory
    {
        return $this->flatCategories[$id] ?? null;
    }

    public function getCategoryByView(string $view): ?INavigatorCategory
    {
        foreach ($this->flatCategories as $category) {
            if (strcasecmp($category->getCaptionSave(), $view) === 0) {
                return $category;
            }
        }

        return null;
    }

    /** @return ArrayObject<int,INavigatorPublicCategory> */
    public function getPublicCategories(): ArrayObject
    {
        return $this->publicCategories;
    }

    public function getPublicCategoryById(int|string $id): ?INavigatorPublicCategory
    {
        return $this->publicCategories[$id] ?? null;
    }

    /** @return ArrayObject<int,IRoom> */
    public function getRoomsForView(string $category, ?IUser $user = null): ArrayObject
    {
        return match ($category) {
            "official-root" => RoomManager::getInstance()->getLoadedPublicRooms(),
            "popular" => RoomManager::getInstance()->getPopularRooms(Hydra::getEmulator()->getConfigManager()->get('hotel.navigator.popular.amount'))
        };
    }

    /** @return ArrayObject<string,NavigatorFilterField> */
    public function getFilterSettings(): ArrayObject
    {
        return $this->filterSettings;
    }

    public function getFilterByKey(string $key): ?NavigatorFilterField
    {
        return $this->filterSettings[$key] ?? null;
    }
}