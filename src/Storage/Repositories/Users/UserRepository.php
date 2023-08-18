<?php

namespace Emulator\Storage\Repositories\Users;

use ArrayObject;
use Emulator\Utils\Logger;
use React\MySQL\QueryResult;
use Emulator\Game\Users\User;
use Emulator\Api\Game\Users\IUser;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Game\Rooms\Data\RoomData;
use Emulator\Storage\Repositories\EmulatorRepository;

abstract class UserRepository extends EmulatorRepository
{
    public static Logger $logger;

    public static function initialize(): void
    {
        self::$logger = new Logger(static::class);
    }

    public static function getLogger(): Logger
    {
        return self::$logger;
    }

    public static function loadUser(string $ticket): ?IUser
    {
        $user = null;

        self::databaseQuery("SELECT u.id, u.username, u.mail, u.account_created,
            u.last_login, u.last_online, u.motto, u.look, u.gender, u.rank, u.credits,
            u.online, u.auth_ticket, u.ip_register, u.ip_current, u.machine_id, u.home_room,
            uSettings.achievement_score, uSettings.respects_received, uSettings.respects_given, uSettings.daily_pet_respect_points,
            uSettings.daily_respect_points, uSettings.block_following, uSettings.block_friendrequests,
            uSettings.block_roominvites, uSettings.old_chat, uSettings.block_camera_follow, uSettings.guild_id, uSettings.tags,
            uSettings.can_trade, uSettings.club_expire_timestamp, uSettings.login_streak, uSettings.rent_space_id,
            uSettings.rent_space_endtime, uSettings.volume_system, uSettings.volume_furni, uSettings.volume_trax,
            uSettings.chat_color, uSettings.hof_points, uSettings.block_alerts, uSettings.talent_track_citizenship_level, uSettings.talent_track_helpers_level,
            uSettings.ignore_bots, uSettings.ignore_pets, uSettings.nux, uSettings.mute_end_timestamp, uSettings.allow_name_change,
            uSettings.perk_trade, uSettings.forums_post_count, uSettings.ui_flags, uSettings.has_gotten_default_saved_searches,
            uSettings.max_friends, uSettings.max_rooms, uSettings.last_hc_payday, uSettings.hc_gifts_claimed
            FROM users u
            JOIN users_settings uSettings ON uSettings.user_id = u.id
            WHERE auth_ticket = ?
        ", function (QueryResult $result) use (&$user) {
            if (empty($result->resultRows)) return;

            $user = new User($result->resultRows[0]);
        }, [$ticket]);

        return $user;
    }

    /** @param ArrayObject<int,IRoom> $ownRoomsProperty */
    public static function loadOwnRooms(IUser $user, ArrayObject &$ownRoomsProperty): void
    {
        self::databaseQuery("SELECT * FROM rooms WHERE owner_id = ?", function (QueryResult $result) use (&$ownRoomsProperty) {
            if (empty($result->resultRows)) return;

            foreach ($result->resultRows as $row) {
                $room = RoomManager::getInstance()->loadRoomFromData(new RoomData($row));

                if (!$room) continue;

                $ownRoomsProperty->append($room);
            }
        }, [$user->getData()->getId()]);
    }
}