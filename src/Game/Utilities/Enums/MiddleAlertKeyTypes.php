<?php

namespace Emulator\Game\Utilities\Enums;

enum MiddleAlertKeyTypes: string
{
    case ADMIN_PERSISTENT = "admin.persistent";
    case ADMIN_TRANSIENT = "admin.transient";
    
    case BUILDERS_CLUB_MEMBERSHIP_EXPIRED = "builders_club.membership_expired";
    case BUILDERS_CLUB_MEMBERSHIP_EXPIRES = "builders_club.membership_expires";
    case BUILDERS_CLUB_MEMBERSHIP_EXTENDED = "builders_club.membership_extended";
    case BUILDERS_CLUB_MEMBERSHIP_MADE = "builders_club.membership_made";
    case BUILDERS_CLUB_MEMBERSHIP_RENEWED = "builders_club.membership_renewed";
    case BUILDERS_CLUB_ROOM_LOCKED = "builders_club.room_locked";
    case BUILDERS_CLUB_ROOM_UNLOCKED = "builders_club.room_unlocked";
    case BUILDERS_CLUB_VISIT_DENIED_OWNER = "builders_club.visit_denied_for_owner";
    case BUILDERS_CLUB_VISIT_DENIED_GUEST = "builders_club.visit_denied_for_visitor";

    case CASINO_TOO_MANY_DICE_PLACEMENT = "casino.too_many_dice.placement";
    case CASINO_TOO_MANY_DICE = "casino.too_many_dice";

    case FLOORPLAN_EDITOR_ERROR = "floorplan_editor.error";

    case FORUMS_DELIVERED = "forums.delivered";
    case FORUMS_FORUM_SETTINGS_UPDATED = "forums.forum_settings_updated";
    case FORUMS_MESSAGE_HIDDEN = "forums.message.hidden";
    case FORUMS_MESSAGE_RESTORED = "forums.message.restored";
    case FORUMS_THREAD_HIDDEN = "forums.thread.hidden";
    case FORUMS_ACCESS_DENIED = "forums.error.access_denied";
    case FORUMS_THREAD_LOCKED = "forums.thread.locked";
    case FORUMS_THREAD_PINNED = "forums.thread.pinned";
    case FORUMS_THREAD_RESTORED = "forums.thread.restored";
    case FORUMS_THREAD_UNLOCKED = "forums.thread.unlocked";
    case FORUMS_THREAD_UNPINNED = "forums.thread.unpinned";

    case FURNITURE_PLACEMENT_ERROR = "furni_placement_error";

    case GIFTING_VALENTINE = "gifting.valentine";

    case NUX_POPUP = "nux.popup";

    case PURCHASING_ROOM = "purchasing.room";

    case RECEIVED_GIFT = "received.gift";
    case RECEIVED_BADGE = "received.badge";

    case FIGURESET_REDEEMED = "figureset.redeemed.success";
    case FIGURESET_OWNED_ALREADY = "figureset.already.redeemed";
}