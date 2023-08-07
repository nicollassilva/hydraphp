<?php

namespace Emulator\Networking\Incoming;

abstract class IncomingHeaders
{
    # Handshake Events
    public static int $releaseVersionEvent = 4000;
    public static int $clientVariablesEvent = 1053;
    public static int $uniqueIdEvent = 2490;
    public static int $ssoTicketEvent = 2419;
    # -----
    
    # Hotel View Events
    public static int $hotelViewRequestBonusRareEvent = 957;
    public static int $hotelViewDataEvent = 2912;
    # -----
    
    # User Events
    public static int $requestUserDataEvent = 357;
    public static int $userActivityEvent = 3457;
    public static int $mySanctionStatusEvent = 2746;
    public static int $requestFriendsEvent = 1523;
    public static int $requestFriendRequestsEvent = 2448;
    public static int $requestInitFriendsEvent = 2781;
    public static int $requestUserCreditsEvent = 273;
    public static int $requestUserClubEvent = 3166;
    public static int $requestIgnoredUsersEvent = 1371;
    public static int $requestMeMenuSettingsEvent = 2388;
    public static int $usernameEvent = 3878;
    public static int $requestUserGroupBadgesEvent = 21;
    # -----

    # Navigator Outgoing Events
    public static int $requestNewNavigatorDataEvent = 2110;
    # -----

    # Game Center Events
    public static int $gameCenterRequestGamesEvent = 741;
    public static int $getGameListMessageEvent = 2399;
    # -----

    # Rooms Events
    public static int $requestPromotedRoomsEvent = 2908;
    public static int $requestRoomCategoriesEvent = 3027;
    public static int $requestNavigatorSettingsEvent = 1782;
    public static int $requestNewNavigatorRoomsEvent = 249;
    public static int $requestRoomDataEvent = 2230;
    public static int $requestRoomLoadEvent = 2312;
    public static int $requestHeightmapEvent = 3898;
    public static int $joinRoomEvent = 685;
    # -----
    
    # Emulator Events
    public static int $pongEvent = 2596;
    public static int $pingEvent = 295;
    # -----

    public static int $requestTargetOfferEvent = 2487;
}