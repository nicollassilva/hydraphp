<?php

namespace Emulator\Game\Catalog\Components;

use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Game\Catalog\Layouts\{
    BadgeDisplayLayout,
    BotsLayout,
    BuildersClubAddonsLayout,
    BuildersClubFrontPageLayout,
    BuildersClubLoyaltyLayout,
    CatalogRootLayout,
    ClubBuyLayout,
    ClubGiftsLayout,
    ColorGroupingLayout,
    Default3x3Layout,
    FrontPageFeaturedLayout,
    FrontPageLayout,
    GroupFrontPageLayout,
    GroupFurnitureLayout,
    GuildForumLayout,
    InfoDucketsLayout,
    InfoLoyaltyLayout,
    InfoMonkeyLayout,
    InfoNikoLayout,
    InfoPetsLayout,
    InfoRentablesLayout,
    LoyaltyVipBuyLayout,
    MadMoneyLayout,
    MarketplaceLayout,
    MarketplaceOwnItemsLayout,
    PetCustomizationLayout,
    Pets2Layout,
    Pets3Layout,
    PetsLayout,
    RecentPurchasesLayout,
    RecyclerInfoLayout,
    RecyclerLayout,
    RecyclerPrizesLayout,
    RoomAdsLayout,
    RoomBundleLayout,
    SingleBundle,
    SoldLTDItemsLayout,
    SpacesLayout,
    TraxLayout,
    TrophiesLayout,
    VipBuyLayout
};

class LayoutComponent
{
    /** @var array<string,ICatalogLayout> */
    private array $layouts = [];

    public function __construct()
    {
        $this->registerLayouts();
    }

    public function getByName(string $name): ?string
    {
        return $this->layouts[$name] ?? null;
    }

    private function registerLayouts(bool $forceReload = false): void
    {
        if (!empty($this->layouts) && !$forceReload) return;

        $this->layouts = [
            'default_3x3' => Default3x3Layout::class,
            'guild_furni' => GroupFurnitureLayout::class,
            'guilds' => GroupFrontPageLayout::class,
            'guild_forum' => GuildForumLayout::class,
            'info_duckets' => InfoDucketsLayout::class,
            'info_rentables' => InfoRentablesLayout::class,
            'info_loyalty' => InfoLoyaltyLayout::class,
            'loyalty_vip_buy' => LoyaltyVipBuyLayout::class,
            'bots' => BotsLayout::class,
            'pets' => PetsLayout::class,
            'pets2' => Pets2Layout::class,
            'pets3' => Pets3Layout::class,
            'club_gift' => ClubGiftsLayout::class,
            'frontpage' => FrontPageLayout::class,
            'badge_display' => BadgeDisplayLayout::class,
            'spaces_new' => SpacesLayout::class,
            'soundmachine' => TraxLayout::class,
            'info_pets' => InfoPetsLayout::class,
            'club_buy' => ClubBuyLayout::class,
            'roomads' => RoomAdsLayout::class,
            'trophies' => TrophiesLayout::class,
            'single_bundle' => SingleBundle::class,
            'marketplace' => MarketplaceLayout::class,
            'marketplace_own_items' => MarketplaceOwnItemsLayout::class,
            'recycler' => RecyclerLayout::class,
            'recycler_info' => RecyclerInfoLayout::class,
            'recycler_prizes' => RecyclerPrizesLayout::class,
            'sold_ltd_items' => SoldLTDItemsLayout::class,
            'plasto' => null,
            'default_3x3_color_grouping' => ColorGroupingLayout::class,
            'recent_purchases' => RecentPurchasesLayout::class,
            'room_bundle' => RoomBundleLayout::class,
            'petcustomization' => PetCustomizationLayout::class,
            'root' => CatalogRootLayout::class,
            'vip_buy' => VipBuyLayout::class,
            'frontpage_featured' => FrontPageFeaturedLayout::class,
            'builders_club_addons' => BuildersClubAddonsLayout::class,
            'builders_club_frontpage' => BuildersClubFrontPageLayout::class,
            'builders_club_loyalty' => BuildersClubLoyaltyLayout::class,
            'monkey' => InfoMonkeyLayout::class,
            'niko' => InfoNikoLayout::class,
            'mad_money' => MadMoneyLayout::class
        ];
    }
}
