<?php

namespace Emulator\Networking\Packages;

use Emulator\Networking\Incoming\IncomingHeaders;
use Emulator\Networking\Incoming\Users\UserWalkingEvent;
use Emulator\Networking\Incoming\Rooms\RequestHeightmapEvent;
use Emulator\Networking\Incoming\Catalog\RequestDiscountEvent;
use Emulator\Networking\Incoming\Catalog\RequestCatalogModeEvent;
use Emulator\Networking\Incoming\Emulator\{PingEvent, PongEvent};
use Emulator\Networking\Incoming\Catalog\RequestRecylerLogicEvent;
use Emulator\Networking\Incoming\Catalog\GetMarketplaceConfigEvent;
use Emulator\Networking\Incoming\Catalog\{RequestTargetOfferEvent};
use Emulator\Networking\Incoming\Catalog\RequestGiftConfigurationEvent;
use Emulator\Networking\Incoming\HotelView\{HotelViewRequestBonusRareEvent,HotelViewDataEvent};
use Emulator\Networking\Incoming\GameCenter\{GetGameListMessageEvent,GameCenterRequestGamesEvent};
use Emulator\Networking\Incoming\Messenger\{RequestFriendRequestsEvent, RequestFriendsEvent,RequestInitFriendsEvent};
use Emulator\Networking\Incoming\Handshake\{UniqueIdEvent, SSOTicketEvent, ReleaseVersionEvent, ClientVariablesEvent};
use Emulator\Networking\Incoming\Navigator\{RequestNavigatorSettingsEvent, RequestNewNavigatorDataEvent, RequestNewNavigatorRoomsEvent};
use Emulator\Networking\Incoming\Rooms\{JoinRoomEvent, RequestPromotedRoomsEvent, RequestRoomCategoriesEvent, RequestRoomDataEvent, RequestRoomLoadEvent};
use Emulator\Networking\Incoming\Users\{UserActivityEvent,RequestUserDataEvent,MySanctionStatusEvent, RequestIgnoredUsersEvent, RequestMeMenuSettingsEvent, RequestUserClubEvent, RequestUserCreditsEvent, UserLookToEvent, UsernameEvent, UserStartTypingEvent, UserStopTypingEvent, UserTalkEvent};

class IncomingPackagesLoader
{
    private array $packages = [];

    public function __construct()
    {
        $this->loadPackages();
    }
    
    private function loadPackages(): void
    {
        $this->loadEmulatorEvents();
        $this->loadHandshakeEvents();
        $this->loadHotelViewEvents();
        $this->loadUsersEvents();
        $this->loadGameCenterEvents();
        $this->loadNavigatorEvents();
        $this->loadRoomsEvents();
        $this->loadCatalogEvents();
    }

    public function hasHeader(int $packageHeader): bool
    {
        return isset($this->packages[$packageHeader]);
    }

    public function getPackageByHeader(int $packageHeader): ?string
    {
        if(!$this->hasHeader($packageHeader)) return null;

        return $this->packages[$packageHeader];
    }

    private function addPackage(int $packageHeader, string $packageClass): void
    {
        $this->packages[$packageHeader] = $packageClass;
    }

    private function loadEmulatorEvents(): void
    {
        $this->addPackage(IncomingHeaders::$pingEvent, PingEvent::class);
        $this->addPackage(IncomingHeaders::$pongEvent, PongEvent::class);
    }

    private function loadHandshakeEvents(): void
    {
        $this->addPackage(IncomingHeaders::$releaseVersionEvent, ReleaseVersionEvent::class);
        $this->addPackage(IncomingHeaders::$clientVariablesEvent, ClientVariablesEvent::class);
        $this->addPackage(IncomingHeaders::$uniqueIdEvent, UniqueIdEvent::class);
        $this->addPackage(IncomingHeaders::$ssoTicketEvent, SSOTicketEvent::class);
    }

    private function loadHotelViewEvents(): void
    {
        $this->addPackage(IncomingHeaders::$hotelViewRequestBonusRareEvent, HotelViewRequestBonusRareEvent::class);
        $this->addPackage(IncomingHeaders::$hotelViewDataEvent, HotelViewDataEvent::class);
    }

    private function loadUsersEvents(): void
    {
        $this->addPackage(IncomingHeaders::$requestUserDataEvent, RequestUserDataEvent::class);
        $this->addPackage(IncomingHeaders::$userActivityEvent, UserActivityEvent::class);
        $this->addPackage(IncomingHeaders::$mySanctionStatusEvent, MySanctionStatusEvent::class);
        $this->addPackage(IncomingHeaders::$requestFriendsEvent, RequestFriendsEvent::class);
        $this->addPackage(IncomingHeaders::$requestFriendRequestsEvent, RequestFriendRequestsEvent::class);
        $this->addPackage(IncomingHeaders::$requestInitFriendsEvent, RequestInitFriendsEvent::class);
        $this->addPackage(IncomingHeaders::$requestUserCreditsEvent, RequestUserCreditsEvent::class);
        $this->addPackage(IncomingHeaders::$requestUserClubEvent, RequestUserClubEvent::class);
        $this->addPackage(IncomingHeaders::$requestIgnoredUsersEvent, RequestIgnoredUsersEvent::class);
        $this->addPackage(IncomingHeaders::$requestMeMenuSettingsEvent, RequestMeMenuSettingsEvent::class);
        $this->addPackage(IncomingHeaders::$userStartTypingEvent, UserStartTypingEvent::class);
        $this->addPackage(IncomingHeaders::$userStopTypingEvent, UserStopTypingEvent::class);
        $this->addPackage(IncomingHeaders::$userTalkEvent, UserTalkEvent::class);
        $this->addPackage(IncomingHeaders::$userWalkingEvent, UserWalkingEvent::class);
        $this->addPackage(IncomingHeaders::$userLookToEvent, UserLookToEvent::class);
        $this->addPackage(IncomingHeaders::$usernameEvent, UsernameEvent::class);
    }

    private function loadGameCenterEvents(): void
    {
        $this->addPackage(IncomingHeaders::$gameCenterRequestGamesEvent, GameCenterRequestGamesEvent::class);
        $this->addPackage(IncomingHeaders::$getGameListMessageEvent, GetGameListMessageEvent::class);
    }

    private function loadNavigatorEvents(): void
    {
        $this->addPackage(IncomingHeaders::$requestNewNavigatorDataEvent, RequestNewNavigatorDataEvent::class);
        $this->addPackage(IncomingHeaders::$requestNavigatorSettingsEvent, RequestNavigatorSettingsEvent::class);
        $this->addPackage(IncomingHeaders::$requestNewNavigatorRoomsEvent, RequestNewNavigatorRoomsEvent::class);
    }

    private function loadRoomsEvents(): void
    {
        $this->addPackage(IncomingHeaders::$requestPromotedRoomsEvent, RequestPromotedRoomsEvent::class);
        $this->addPackage(IncomingHeaders::$requestRoomCategoriesEvent, RequestRoomCategoriesEvent::class);
        $this->addPackage(IncomingHeaders::$requestRoomDataEvent, RequestRoomDataEvent::class);
        $this->addPackage(IncomingHeaders::$requestRoomLoadEvent, RequestRoomLoadEvent::class);
        $this->addPackage(IncomingHeaders::$joinRoomEvent, JoinRoomEvent::class);
        $this->addPackage(IncomingHeaders::$requestHeightmapEvent, RequestHeightmapEvent::class);
    }

    private function loadCatalogEvents(): void
    {
        $this->addPackage(IncomingHeaders::$requestTargetOfferEvent, RequestTargetOfferEvent::class);
        $this->addPackage(IncomingHeaders::$requestCatalogModeEvent, RequestCatalogModeEvent::class);
        $this->addPackage(IncomingHeaders::$getMarketplaceConfigEvent, GetMarketplaceConfigEvent::class);
        $this->addPackage(IncomingHeaders::$requestRecylerLogicEvent, RequestRecylerLogicEvent::class);
        $this->addPackage(IncomingHeaders::$requestGiftConfigurationEvent, RequestGiftConfigurationEvent::class);
        $this->addPackage(IncomingHeaders::$requestDiscountEvent, RequestDiscountEvent::class);
    }
}