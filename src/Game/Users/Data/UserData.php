<?php

namespace Emulator\Game\Users\Data;

use Emulator\Game\Users\UserManager;
use Emulator\Api\Game\Users\Data\IUserData;

class UserData implements IUserData
{
    private int $id;
    private string $username;
    private string $email;
    private string $accountCreated;
    private string $lastLogin;
    private string $lastOnline;
    private string $motto;
    private string $look;
    private string $gender;
    private int $rank;
    private int $credits;
    private int $pixels;
    private int $diamonds;
    private int $seasonalPoints;
    private bool $isOnline;
    private string $authTicket;
    private string $registerIp;
    private string $currentIp;
    private string $machineId;
    private int $homeRoom;

    public function __construct(array &$data)
    {
        try {
            $this->id = $data['id'];
            $this->username = $data['username'];
            $this->email = $data['mail'];
            $this->accountCreated = $data['account_created'];
            $this->lastLogin = $data['last_login'];
            $this->lastOnline = $data['last_online'];
            $this->motto = $data['motto'];
            $this->look = $data['look'];
            $this->gender = $data['gender'];
            $this->rank = $data['rank'];
            $this->credits = $data['credits'];
            $this->pixels = 0;
            $this->diamonds = 0;
            $this->seasonalPoints = 0;
            $this->isOnline = $data['online'];
            $this->authTicket = $data['auth_ticket'];
            $this->registerIp = $data['ip_register'];
            $this->currentIp = $data['ip_current'];
            $this->machineId = $data['machine_id'];
            $this->homeRoom = $data['home_room'];
        } catch (\Throwable $e) {
            UserManager::getInstance()->getLogger()->error("Failed to load user data: " . $e->getMessage());
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAccountCreated(): string
    {
        return $this->accountCreated;
    }

    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }

    public function getLastOnline(): string
    {
        return $this->lastOnline;
    }

    public function getMotto(): string
    {
        return $this->motto;
    }

    public function getLook(): string
    {
        return $this->look;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getCredits(): int
    {
        return $this->credits;
    }

    public function getPixels(): int
    {
        return $this->pixels;
    }

    public function getDiamonds(): int
    {
        return $this->diamonds;
    }

    public function getSeasonalPoints(): int
    {
        return $this->seasonalPoints;
    }

    public function isOnline(): bool
    {
        return $this->isOnline;
    }

    public function getAuthTicket(): string
    {
        return $this->authTicket;
    }

    public function getRegisterIp(): string
    {
        return $this->registerIp;
    }

    public function getCurrentIp(): string
    {
        return $this->currentIp;
    }

    public function getMachineId(): string
    {
        return $this->machineId;
    }

    public function getHomeRoom(): int
    {
        return $this->homeRoom;
    }
}