<?php

namespace Emulator\Api\Game\Users\Data;

interface IUserData
{
    public function getId(): int;
    public function getUsername(): string;
    public function getEmail(): string;
    public function getAccountCreated(): string;
    public function getLastLogin(): string;
    public function getLastOnline(): string;
    public function getMotto(): string;
    public function getLook(): string;
    public function getGender(): string;
    public function getRank(): int;
    public function getCredits(): int;
    public function getPixels(): int;
    public function getDiamonds(): int;
    public function getSeasonalPoints(): int;
    public function isOnline(): bool;
    public function getAuthTicket(): string;
    public function getRegisterIp(): string;
    public function getCurrentIp(): string;
    public function getMachineId(): string;
    public function getHomeRoom(): int;
}