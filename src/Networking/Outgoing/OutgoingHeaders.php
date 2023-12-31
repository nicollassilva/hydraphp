<?php

namespace Emulator\Networking\Outgoing;

abstract class OutgoingHeaders
{
    # Handshake Outgoing Events
    public static int $uniqueMachineIdComposer = 1488;
    public static int $secureLoginOkComposer = 2491;
    # -----

    # User Outgoing Events
    public static int $enableNotificationsComposer = 3284;
    public static int $userAchievementsScoreComposer = 1968;
    public static int $userPermissionsComposer = 411;
    public static int $userClothesComposer = 1450;
    public static int $newUserIdentityComposer = 3738;
    public static int $isFirstLoginOfDayComposer = 793;
    public static int $buildersClubExpiredComposer = 1452;
    public static int $favoriteRoomsCountComposer = 151;
    public static int $cfhTopicsComposer = 325;
    public static int $userClubComposer = 954;
    public static int $userHomeRoomComposer = 2875;
    public static int $mysteryBoxKeysComposer = 2833;
    public static int $userDataComposer = 2725;
    public static int $userPerksComposer = 2586;
    public static int $meMenuSettingsComposer = 513;
    public static int $modToolSanctionInfoComposer = 2221;
    public static int $userCreditsComposer = 3475;
    public static int $userCurrencyComposer = 2018;
    public static int $ignoredUsersComposer = 126;
    public static int $loadFriendRequestsComposer = 280;
    
    public static int $roomUsersComposer = 374;
    public static int $roomUserStatusComposer = 1640;
    public static int $roomRightsComposer = 780;
    public static int $roomOwnerComposer = 339;
    public static int $userTypingComposer = 1717;
    public static int $userTalkComposer = 1446;
    # -----

    # Hotel View Outgoing Events
    public static int $bonusRareComposer = 1533;
    public static int $hotelViewDataComposer = 1745;
    public static int $adventCalendarDataComposer = 2531;
    public static int $hotelViewComposer = 122;
    # -----
    
    # Inventory Outgoing Events
    public static int $inventoryEffectsComposer = 340;
    public static int $inventoryAchievementsComposer = 2501;
    public static int $inventoryRefreshComposer = 3151;
    # -----

    # Game Center Outgoing Events
    public static int $gameCenterGameListComposer = 222;
    public static int $gameCenterAccountInfoComposer = 2893;
    public static int $gameCenterAchievementsConfigurationComposer = 2265;
    # -----

    # Messenger Outgoing Events
    public static int $messengerInitComposer = 1605;
    # -----

    # Rooms Outgoing Events
    public static int $privateRoomsComposer = 52;
    public static int $roomCategoriesComposer = 1562;
    public static int $newNavigatorSearchResultsComposer = 2690;
    public static int $roomDataComposer = 687;
    public static int $hideDoorbellComposer = 3783;
    public static int $roomOpenComposer = 758;
    public static int $roomModelComposer = 2031;
    public static int $roomPaintComposer = 2454;
    public static int $roomScoreComposer = 482;
    public static int $roomPromotionComposer = 1840;
    public static int $roomPaneComposer = 749;
    public static int $roomThicknessComposer = 3547;
    public static int $roomWallItemsComposer = 1369;
    public static int $roomFloorItemsComposer = 1778;
    public static int $roomGroupBadgesComposer = 2402;
    public static int $roomRightsListComposer = 1284;
    public static int $roomRelativeMapComposer = 2753;
    public static int $roomHeightmapComposer = 1301;
    public static int $removeUserComposer = 2661;
    public static int $canCreateRoomComposer = 378;
    public static int $roomCreatedComposer = 1304;
    # -----

    # Catalog Outgoing Events
    public static int $targetedOfferComposer = 119;
    public static int $catalogModeComposer = 3828;
    public static int $catalogPagesListComposer = 1032;
    public static int $marketplaceConfigComposer = 1823;
    public static int $recyclerLogicComposer = 3164;
    public static int $giftConfigurationComposer = 2234;
    public static int $catalogDiscountComposer = 2347;
    public static int $catalogPageComposer = 804;
    # -----
    
    # Navigator Outgoing Events
    public static int $newNavigatorSettingsComposer = 518;
    public static int $newNavigatorMetaDataComposer = 3052;
    public static int $newNavigatorLiftedRoomsComposer = 3104;
    public static int $newNavigatorCollapsedCategoriesComposer = 1543;
    public static int $newNavigatorSavedSearchesComposer = 3984;
    public static int $newNavigatorEventCategoriesComposer = 3244;
    # -----
    
    public static int $availabilityStatusComposer = 2033;
    public static int $pingComposer = 3928;
    public static int $pongComposer = 10;
    
    # Alerts Outgoing Events
    public static int $middleAlertComposer = 1992;
    public static int $alertPurchaseFailedComposer = 1404;
    public static int $genericErrorComposer = 1600;
    public static int $alertPurchaseUnavailableComposer = 3770;
    # -----
}