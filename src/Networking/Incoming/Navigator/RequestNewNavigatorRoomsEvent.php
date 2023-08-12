<?php

namespace Emulator\Networking\Incoming\Navigator;

use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Game\Navigator\NavigatorFilterManager;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Game\Navigator\Search\NavigatorSearchList;
use Emulator\Api\Game\Navigator\Data\INavigatorCategory;
use Emulator\Api\Game\Navigator\Filters\INavigatorFilter;
use Emulator\Game\Navigator\Filters\NavigatorPublicFilter;
use Emulator\Networking\Outgoing\Rooms\NewNavigatorSearchResultsComposer;
use Emulator\Game\Navigator\Enums\{NavigatorSearchAction,NavigatorDisplayOrder,NavigatorDisplayMode,NavigatorListMode};

class RequestNewNavigatorRoomsEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $view = $message->readString();
        $search = $message->readString();

        if (in_array($view, ['query', 'groups'])) {
            $view = "hotel_view";
        }

        $filter = NavigatorFilterManager::getInstance()->getFilterForView($view);
        $category = NavigatorManager::getInstance()->getCategoryByView($view);

        if(!($filter instanceof INavigatorFilter)) {
            $filter = NavigatorFilterManager::getInstance()->getFilterForView(NavigatorPublicFilter::FILTER_NAME);
        }

        if(!($category instanceof INavigatorCategory)) {
            $category = NavigatorManager::getInstance()->getCategoryByView(NavigatorPublicFilter::FILTER_NAME);
        }

        $filterField = NavigatorManager::getInstance()->getFilterByKey('anything');

        if(($filterField == null || empty($search)) && !($filter instanceof INavigatorFilter)) return;

        /** @var array<NavigatorSearchList> */
        $resultList = $filter->getFilterResult();

        if(!empty($search)) {
            $resultList = new NavigatorSearchList(
                0, 'query', '', NavigatorSearchAction::None, NavigatorListMode::List, NavigatorDisplayMode::Visible, true, true, NavigatorDisplayOrder::Activity, -1, $filter->getRooms($resultList)
            );
        }

        if(empty($filter)) return;

        $client->send(new NewNavigatorSearchResultsComposer($view, $search, $resultList));
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}