<?php

namespace Emulator\Networking\Outgoing\Navigator;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class NewNavigatorCollapsedCategoriesComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$newNavigatorCollapsedCategoriesComposer;

        $this->writeInt(46);
        $this->writeString("new_ads");
        $this->writeString("friend_finding");
        $this->writeString("staffpicks");
        $this->writeString("with_friends");
        $this->writeString("with_rights");
        $this->writeString("query");
        $this->writeString("recommended");
        $this->writeString("my_groups");
        $this->writeString("favorites");
        $this->writeString("history");
        $this->writeString("top_promotions");
        $this->writeString("campaign_target");
        $this->writeString("friends_rooms");
        $this->writeString("groups");
        $this->writeString("metadata");
        $this->writeString("history_freq");
        $this->writeString("highest_score");
        $this->writeString("competition");
        $this->writeString("category__Agencies");
        $this->writeString("category__Role Playing");
        $this->writeString("category__Global Chat & Discussi");
        $this->writeString("category__GLOBAL BUILDING AND DE");
        $this->writeString("category__global party");
        $this->writeString("category__global games");
        $this->writeString("category__global fansite");
        $this->writeString("category__global help");
        $this->writeString("category__Trading");
        $this->writeString("category__global personal space");
        $this->writeString("category__Habbo Life");
        $this->writeString("category__TRADING");
        $this->writeString("category__global official");
        $this->writeString("category__global trade");
        $this->writeString("category__global reviews");
        $this->writeString("category__global bc");
        $this->writeString("category__global personal space");
        $this->writeString("eventcategory__Hottest Events");
        $this->writeString("eventcategory__Parties & Music");
        $this->writeString("eventcategory__Role Play");
        $this->writeString("eventcategory__Help Desk");
        $this->writeString("eventcategory__Trading");
        $this->writeString("eventcategory__Games");
        $this->writeString("eventcategory__Debates & Discuss");
        $this->writeString("eventcategory__Grand Openings");
        $this->writeString("eventcategory__Friending");
        $this->writeString("eventcategory__Jobs");
        $this->writeString("eventcategory__Group Events");
    }
}