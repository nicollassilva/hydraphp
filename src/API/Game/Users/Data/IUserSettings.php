<?php

namespace Emulator\Api\Game\Users\Data;

interface IUserSettings
{
    public function getAchievementScore(): int;
    public function getRespectPointsReceived(): int;
    public function getRespectPointsGiven(): int;
    public function getPetRespectPointsToGive(): int;
    public function getRespectPointsToGive(): int;
    public function getBlockFollowing(): bool;
    public function getBlockFriendRequests(): bool;
    public function getBlockRoomInvites(): bool;
    public function getPreferOldChat(): bool;
    public function getBlockCameraFollow(): bool;
    public function getGuild(): int;
    public function getTags(): array;
    public function getAllowTrade(): bool;
    public function getVotedRooms(): array;
    public function getClubExpireTimestamp(): int;
    public function getLoginStreak(): int;
    public function getRentedItemId(): int;
    public function getRentedTimeEnd(): string;
    public function getVolumeSystem(): int;
    public function getVolumeFurni(): int;
    public function getVolumeTrax(): int;
    public function getChatColor(): array;
    public function getHofPoints(): int;
    public function getBlockStaffAlerts(): bool;
    public function getCitizenshipLevel(): int;
    public function getHelpersLevel(): int;
    public function getIgnoreBots(): bool;
    public function getIgnorePets(): bool;
    public function getNux(): bool;
    public function getMuteEndTime(): string;
    public function getAllowNameChange(): bool;
    public function getPerkTrade(): bool;
    public function getForumPostsCount(): int;
    public function getUiFlags(): int;
    public function getHasGottenDefaultSavedSearches(): bool;
    public function getMaxFriends(): int;
    public function getMaxRooms(): int;
    public function getLastHCPayday(): int;
    public function getHcGiftsClaimed(): int;
}