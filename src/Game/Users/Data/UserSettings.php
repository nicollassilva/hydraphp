<?php

namespace Emulator\Game\Users\Data;

use Throwable;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Game\Users\UserManager;
use Emulator\Api\Game\Rooms\Data\IChatBubble;
use Emulator\Api\Game\Users\Data\IUserSettings;

class UserSettings implements IUserSettings
{
    private int $achievementScore;
    private int $respectPointsReceived;
    private int $respectPointsGiven;
    private int $petRespectPointsToGive;
    private int $respectPointsToGive;
    private bool $blockFollowing;
    private bool $blockFriendRequests;
    private bool $blockRoomInvites;
    private bool $preferOldChat;
    private bool $blockCameraFollow;
    private int $guild;
    private array $tags;
    private bool $allowTrade;
    private array $votedRooms;
    private int $clubExpireTimestamp;
    private int $loginStreak;
    private int $rentedItemId;
    private string $rentedTimeEnd;
    private int $volumeSystem;
    private int $volumeFurni;
    private int $volumeTrax;
    private ?IChatBubble $chatColor;
    private int $hofPoints;
    private bool $blockStaffAlerts;
    private int $citizenshipLevel;
    private int $helpersLevel;
    private bool $ignoreBots;
    private bool $ignorePets;
    private bool $nux;
    private string $muteEndTime;
    private bool $allowNameChange;
    private bool $perkTrade;
    private int $forumPostsCount;
    private int $uiFlags;
    private bool $hasGottenDefaultSavedSearches;
    private int $maxFriends;
    private int $maxRooms;
    private int $lastHCPayday;
    private int $hcGiftsClaimed;

    public function __construct(array &$data)
    {
        try {
            $this->achievementScore = $data["achievement_score"];
            $this->respectPointsReceived = $data["respects_received"];
            $this->respectPointsGiven = $data["respects_given"];
            $this->petRespectPointsToGive = $data["daily_pet_respect_points"];
            $this->respectPointsToGive = $data["daily_respect_points"];
            $this->blockFollowing = (bool)$data["block_following"];
            $this->blockFriendRequests = (bool)$data["block_friendrequests"];
            $this->blockRoomInvites = (bool)$data["block_roominvites"];
            $this->preferOldChat = (bool)$data["old_chat"];
            $this->blockCameraFollow = (bool)$data["block_camera_follow"];
            $this->guild = $data["guild_id"];
            $this->tags = explode(';', $data["tags"]);
            $this->allowTrade = (bool)$data["can_trade"];
            $this->votedRooms = [];
            $this->clubExpireTimestamp = $data["club_expire_timestamp"];
            $this->loginStreak = $data["login_streak"];
            $this->rentedItemId = $data["rent_space_id"];
            $this->rentedTimeEnd = $data["rent_space_endtime"];
            $this->volumeSystem = $data["volume_system"];
            $this->volumeFurni = $data["volume_furni"];
            $this->volumeTrax = $data["volume_trax"];
            $this->chatColor = RoomManager::getInstance()->getChatBubblesComponent()->getChatBubbleById($data["chat_color"]);
            $this->hofPoints = $data["hof_points"];
            $this->blockStaffAlerts = $data["block_alerts"];
            $this->citizenshipLevel = $data["talent_track_citizenship_level"];
            $this->helpersLevel = $data["talent_track_helpers_level"];
            $this->ignoreBots = $data["ignore_bots"];
            $this->ignorePets = $data["ignore_pets"];
            $this->nux = $data["nux"];
            $this->muteEndTime = $data["mute_end_timestamp"];
            $this->allowNameChange = $data["allow_name_change"];
            $this->perkTrade = $data["perk_trade"];
            $this->forumPostsCount = $data["forums_post_count"];
            $this->uiFlags = $data["ui_flags"];
            $this->hasGottenDefaultSavedSearches = (bool)$data["has_gotten_default_saved_searches"];
            $this->maxFriends = $data["max_friends"];
            $this->maxRooms = $data["max_rooms"];
            $this->lastHCPayday = $data["last_hc_payday"];
            $this->hcGiftsClaimed = $data["hc_gifts_claimed"];
        } catch (Throwable $error) {
            UserManager::getInstance()->getLogger()->error('Error while constructing a user settings: ' . $error->getMessage());
        }
    }

    public function getAchievementScore(): int
    {
        return $this->achievementScore;
    }

    public function getRespectPointsReceived(): int
    {
        return $this->respectPointsReceived;
    }

    public function getRespectPointsGiven(): int
    {
        return $this->respectPointsGiven;
    }

    public function getPetRespectPointsToGive(): int
    {
        return $this->petRespectPointsToGive;
    }

    public function getRespectPointsToGive(): int
    {
        return $this->respectPointsToGive;
    }

    public function getBlockFollowing(): bool
    {
        return $this->blockFollowing;
    }

    public function getBlockFriendRequests(): bool
    {
        return $this->blockFriendRequests;
    }

    public function getBlockRoomInvites(): bool
    {
        return $this->blockRoomInvites;
    }

    public function getPreferOldChat(): bool
    {
        return $this->preferOldChat;
    }

    public function getBlockCameraFollow(): bool
    {
        return $this->blockCameraFollow;
    }

    public function getGuild(): int
    {
        return $this->guild;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getAllowTrade(): bool
    {
        return $this->allowTrade;
    }

    public function getVotedRooms(): array
    {
        return $this->votedRooms;
    }

    public function getClubExpireTimestamp(): int
    {
        return $this->clubExpireTimestamp;
    }

    public function getLoginStreak(): int
    {
        return $this->loginStreak;
    }

    public function getRentedItemId(): int
    {
        return $this->rentedItemId;
    }

    public function getRentedTimeEnd(): string
    {
        return $this->rentedTimeEnd;
    }

    public function getVolumeSystem(): int
    {
        return $this->volumeSystem;
    }

    public function getVolumeFurni(): int
    {
        return $this->volumeFurni;
    }

    public function getVolumeTrax(): int
    {
        return $this->volumeTrax;
    }

    public function getChatColor(): IChatBubble
    {
        return $this->chatColor;
    }

    public function getHofPoints(): int
    {
        return $this->hofPoints;
    }

    public function getBlockStaffAlerts(): bool
    {
        return $this->blockStaffAlerts;
    }

    public function getCitizenshipLevel(): int
    {
        return $this->citizenshipLevel;
    }

    public function getHelpersLevel(): int
    {
        return $this->helpersLevel;
    }

    public function getIgnoreBots(): bool
    {
        return $this->ignoreBots;
    }

    public function getIgnorePets(): bool
    {
        return $this->ignorePets;
    }

    public function getNux(): bool
    {
        return $this->nux;
    }

    public function getMuteEndTime(): string
    {
        return $this->muteEndTime;
    }

    public function getAllowNameChange(): bool
    {
        return $this->allowNameChange;
    }

    public function getPerkTrade(): bool
    {
        return $this->perkTrade;
    }

    public function getForumPostsCount(): int
    {
        return $this->forumPostsCount;
    }

    public function getUiFlags(): int
    {
        return $this->uiFlags;
    }

    public function getHasGottenDefaultSavedSearches(): bool
    {
        return $this->hasGottenDefaultSavedSearches;
    }

    public function getMaxFriends(): int
    {
        return $this->maxFriends;
    }

    public function getMaxRooms(): int
    {
        return $this->maxRooms;
    }

    public function getLastHCPayday(): int
    {
        return $this->lastHCPayday;
    }

    public function getHcGiftsClaimed(): int
    {
        return $this->hcGiftsClaimed;
    }
}