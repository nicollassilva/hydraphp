<?php

namespace Emulator\Networking\Incoming\Navigator;

use ArrayObject;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Game\Navigator\NavigatorFilterManager;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Game\Navigator\Data\NavigatorFilterField;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Filters\NavigatorPublicFilter;
use Emulator\Networking\Outgoing\Rooms\NewNavigatorSearchResultsComposer;
use Emulator\Game\Navigator\Enums\{NavigatorListMode, NavigatorDisplayMode, NavigatorSearchAction, NavigatorDisplayOrder};

class RequestNewNavigatorRoomsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $view = $message->readString();
        $search = $message->readString();

        if (in_array($view, ['query', 'groups'])) {
            $view = "hotel_view";
        }

        $filter = NavigatorFilterManager::getInstance()->getFilterForView($view, $client->getUser(), NavigatorPublicFilter::FILTER_NAME);
        $category = NavigatorManager::getInstance()->getCategoryByView($view);

        $filterField = NavigatorManager::getInstance()->getFilterByKey('anything');

        if (($filterField == null || empty($search)) && !($filter instanceof INavigatorFilter)) return;

        /** @var ArrayObject<NavigatorSearchList> $resultList */
        $resultList = $filter->getFilterResult();

        if (empty($search)) {
            $client->send(new NewNavigatorSearchResultsComposer($view, $search, $resultList));
            return;
        }

        $filterField = $this->resolveNavigatorSearch($search, $filterField);

        $resultList = new ArrayObject(new NavigatorSearchList(
            0, 'query', '', NavigatorSearchAction::None, NavigatorListMode::List, NavigatorDisplayMode::Visible, true, true, NavigatorDisplayOrder::Activity, -1, $filter->getRooms($resultList)
        ));
    }

    private function resolveNavigatorSearch(string &$search, NavigatorFilterField &$defaultFilter): ?NavigatorFilterField
    {
        $filterField = &$defaultFilter;
        $parsedSearch = explode(':', $search);

        if (count($parsedSearch) <= 1) {
            $search = str_replace(':', '', $search);

            $filterField = NavigatorManager::getInstance()->getFilterByKey($search);
        }

        if (!$filterField) {
            $filterField = &$defaultFilter;
        }

        return $filterField;
    }

    public function needsAuthentication(): bool
    {
        return true;
    }
}