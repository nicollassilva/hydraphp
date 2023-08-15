<?php

namespace Emulator\Game\Navigator;

use ArrayObject;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Navigator\INavigatorFilterManager;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Filters\{NavigatorHotelFilter, NavigatorPublicFilter, NavigatorUserViewFilter, NavigatorRoomEventFilter};

class NavigatorFilterManager implements INavigatorFilterManager
{
    public static NavigatorFilterManager $instance;

    private readonly Logger $logger;

    private bool $isStarted = false;

    /** @property ArrayObject<int,INavigatorFilter> */
    private ArrayObject $filters;

    public function __construct()
    {
        $this->logger = new Logger(get_class($this));

        $this->filters = new ArrayObject;
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
        $this->filters->offsetSet(NavigatorPublicFilter::FILTER_NAME, NavigatorPublicFilter::class);
        $this->filters->offsetSet(NavigatorHotelFilter::FILTER_NAME, NavigatorHotelFilter::class);
        $this->filters->offsetSet(NavigatorRoomEventFilter::FILTER_NAME, NavigatorRoomEventFilter::class);
        $this->filters->offsetSet(NavigatorUserViewFilter::FILTER_NAME, NavigatorUserViewFilter::class);
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function getFilterForView(string &$view, IUser $user, string $fallbackView): ?INavigatorFilter
    {
        $filter = $this->filters->offsetGet($view);

        if (!$filter) {
            $filter = $this->filters->offsetGet($fallbackView);
        }

        return new $filter($user);
    }
}