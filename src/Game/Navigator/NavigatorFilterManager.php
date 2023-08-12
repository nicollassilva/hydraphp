<?php

namespace Emulator\Game\Navigator;

use Emulator\Utils\Logger;
use Emulator\Game\Navigator\Filters\NavigatorFilter;
use Emulator\Api\Game\Navigator\INavigatorFilterManager;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Filters\NavigatorHotelFilter;
use Emulator\Game\Navigator\Filters\NavigatorPublicFilter;

class NavigatorFilterManager implements INavigatorFilterManager
{
    public static NavigatorFilterManager $instance;

    private readonly Logger $logger;

    private bool $isStarted = false;

    /** @param array<int,NavigatorFilter> */
    private array $filters = [];

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));
    }

    public static function getInstance(): NavigatorFilterManager
    {
        if (!isset(self::$instance)) self::$instance = new NavigatorFilterManager();

        return self::$instance;
    }

    public function initialize(): void
    {
        if ($this->isStarted) return;

        $this->loadNavigatorFilters();

        $this->isStarted = true;
    }

    private function loadNavigatorFilters(): void
    {
        $this->filters[NavigatorPublicFilter::FILTER_NAME] = new NavigatorPublicFilter;
        $this->filters[NavigatorHotelFilter::FILTER_NAME] = new NavigatorHotelFilter;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function getFilterForView(string &$view): ?INavigatorFilter
    {
        return $this->filters[$view] ?? null;
    }
}