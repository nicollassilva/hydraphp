<?php

namespace Emulator\Networking\Incoming\Navigator;

use ArrayObject;
use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Game\Navigator\NavigatorFilterManager;
use Emulator\Game\Navigator\Enums\NavigatorListMode;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Game\Navigator\Enums\NavigatorDisplayMode;
use Emulator\Api\Game\Navigator\Data\INavigatorCategory;
use Emulator\Game\Navigator\Enums\NavigatorDisplayOrder;
use Emulator\Game\Navigator\Enums\NavigatorSearchAction;
use Emulator\Game\Navigator\Filters\NavigatorPublicFilter;
use Emulator\Networking\Outgoing\Rooms\NewNavigatorSearchResultsComposer;

class RequestNewNavigatorRoomsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $view = $this->normalizeView($message->readString());
        $search = $message->readString();

        $filter = NavigatorFilterManager::getInstance()->getFilterForView($view, $client->getUser(), NavigatorPublicFilter::FILTER_NAME);
        $category = NavigatorManager::getInstance()->getCategoryByView($view);

        if (empty($filter)) {
            $this->treatEmptyFilter($client, $view, $search);
            return;
        }

        $filterField = NavigatorManager::getInstance()->getFilterByKey('anything');

        if (empty($filterField)) return;

        /** @var ArrayObject<NavigatorSearchList> $resultList */
        $resultList = $filter->getFilterResult();

        if (empty($search)) {
            $client->send(new NewNavigatorSearchResultsComposer($view, $search, $resultList));
            return;
        }

        $parsedSearch = explode(':', $search);

        if (count($parsedSearch) <= 1) {
            $resultList = $filter->getFilterResultBySearch($filterField, $search[0], $category instanceof INavigatorCategory ? $category->getId() : -1);

            $client->send(new NewNavigatorSearchResultsComposer($view, $search, $resultList));
            return;
        }

        $filterField = NavigatorManager::getInstance()->getFilterByKey(str_replace(':', '', $parsedSearch[0]));

        if (empty($filterField)) return;

        $resultList = $filter->getFilterResultBySearch($filterField, str_replace(' ', '', $parsedSearch[1]), $category instanceof INavigatorCategory ? $category->getId() : -1);

        $client->send(new NewNavigatorSearchResultsComposer($view, $search, $resultList));
    }

    public function normalizeView(string $view): string
    {
        if (in_array($view, ['query', 'groups'])) {
            $view = "hotel_view";
        }

        return $view;
    }

    public function treatEmptyFilter(IClient $client, string $view, string $search): void
    {
        $rooms = NavigatorManager::getInstance()->getRoomsForView($view, $client->getUser());

        if (!$rooms->count()) return;

        $resultList = new ArrayObject();

        $resultList->append(
            new NavigatorSearchList(
                0, $view, $search, NavigatorSearchAction::None, NavigatorListMode::List, NavigatorDisplayMode::Visible, true, true, NavigatorDisplayOrder::Activity, -1, $rooms
            )
        );

        $client->send(new NewNavigatorSearchResultsComposer($view, $search, $resultList));
    }

    public function needsAuthentication(): bool
    {
        return true;
    }
}