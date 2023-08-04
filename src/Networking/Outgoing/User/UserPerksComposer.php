<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class UserPerksComposer extends MessageComposer
{
    public function __construct()
    {
        $this->header = OutgoingHeaders::$userPerksComposer;

        $this->writeInt32(15);

        $this->writeString("USE_GUIDE_TOOL");
        $this->writeString("requirement.unfulfilled.helper_level_4");
        $this->writeBoolean(true);

        $this->writeString("GIVE_GUIDE_TOURS");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("JUDGE_CHAT_REVIEWS");
        $this->writeString("requirement.unfulfilled.helper_level_6");
        $this->writeBoolean(true);

        $this->writeString("VOTE_IN_COMPETITIONS");
        $this->writeString("requirement.unfulfilled.helper_level_2");
        $this->writeBoolean(true);

        $this->writeString("CALL_ON_HELPERS");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("CITIZEN");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("TRADE");
        $this->writeString("requirement.unfulfilled.no_trade_lock");
        $this->writeBoolean(true);

        $this->writeString("HEIGHTMAP_EDITOR_BETA");
        $this->writeString("requirement.unfulfilled.feature_disabled");
        $this->writeBoolean(true);

        $this->writeString("BUILDER_AT_WORK");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("CALL_ON_HELPERS");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("CAMERA");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("NAVIGATOR_PHASE_TWO_2014");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("MOUSE_ZOOM");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("NAVIGATOR_ROOM_THUMBNAIL_CAMERA");
        $this->writeString("");
        $this->writeBoolean(true);

        $this->writeString("HABBO_CLUB_OFFER_BETA");
        $this->writeString("");
        $this->writeBoolean(true);
    }
}