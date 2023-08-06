<?php

namespace Emulator\Game\Rooms\Data;

use Emulator\Api\Game\Rooms\Data\IRoomData;
use Emulator\Game\Rooms\Enums\RoomStateEnum;

class RoomData implements IRoomData
{
    private int $id;
    private string $name;
    private string $description;
    private string $model;
    private int $ownerId;
    private string $ownerName;
    private int $currentUsers;
    private int $maxUsers;
    private int $score;
    private string $password;
    private RoomStateEnum $state;
    private int $guildId;
    private string $category;
    private string $paperFloor;
    private string $paperWall;
    private string $paperLandscape;
    private int $thicknessWall;
    private int $wallHeight;
    private int $thicknessFloor;
    private string $moodlightData;
    private array $tags;
    private bool $isPublic;
    private bool $isStaffPicked;
    private bool $allowPets;
    private bool $allowPetsEat;
    private bool $allowWalkthrough;
    private bool $hideWall;
    private int $chatMode;
    private int $chatWeight;
    private int $chatSpeed;
    private int $chatDistance;
    private int $chatProtection;
    private bool $overrideModel;
    private int $whoCanMute;
    private int $whoCanKick;
    private int $whoCanBan;
    private int $pollId;
    private int $rollerSpeed;
    private bool $isPromoted;
    private int $tradeMode;
    private bool $canMoveDiagonally;
    private bool $hasJukeboxActive;
    private bool $hideWireds;
    private bool $isForSale;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->model = $data['model'];
        $this->ownerId = $data['ownerId'];
        $this->ownerName = $data['owner_name'];
        $this->currentUsers = $data['users'];
        $this->maxUsers = $data['users_max'];
        $this->score = $data['score'];
        $this->password = $data['password'];
        $this->state = RoomStateEnum::getState($data['state']);
        $this->category = $data['category'];
        $this->paperFloor = $data['paper_floor'];
        $this->paperWall = $data['paper_wall'];
        $this->paperLandscape = $data['paper_landscape'];
        $this->thicknessWall = $data['thickness_wall'];
        $this->wallHeight = $data['wall_height'];
        $this->thicknessFloor = $data['thickness_floor'];
        $this->moodlightData = $data['moodlight_data'];
        $this->tags = explode(';', $data['tags']);
        $this->isPublic = (bool) $data['is_public'];
        $this->isStaffPicked = (bool) $data['is_staff_picked'];
        $this->allowPets = (bool) $data['allow_other_pets'];
        $this->allowPetsEat = (bool) $data['allow_other_pets_eat'];
        $this->allowWalkthrough = (bool) $data['allow_walkthrough'];
        $this->hideWall = (bool) $data['hide_wall'];
        $this->chatMode = $data['chat_mode'];
        $this->chatWeight = $data['chat_weight'];
        $this->chatSpeed = $data['chat_speed'];
        $this->chatDistance = $data['chat_distance'];
        $this->chatProtection = $data['chat_protection'];
        $this->overrideModel = (bool) $data['override_model'];
        $this->whoCanMute = $data['who_can_mute'];
        $this->whoCanKick = $data['who_can_kick'];
        $this->whoCanBan = $data['who_can_ban'];
        $this->pollId = $data['poll_id'];
        $this->rollerSpeed = $data['roller_speed'];
        $this->isPromoted = (bool) $data['promoted'];
        $this->tradeMode = $data['trade_mode'];
        $this->canMoveDiagonally = (bool) $data['move_diagonally'];
        $this->hasJukeboxActive = (bool) $data['jukebox_active'];
        $this->hideWireds = (bool) $data['hide_wired'];
        $this->isForSale = (bool) $data['is_forsale'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getOwnerName(): string
    {
        return $this->ownerName;
    }

    public function getCurrentUsers(): int
    {
        return $this->currentUsers;
    }

    public function getMaxUsers(): int
    {
        return $this->maxUsers;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getState(): RoomStateEnum
    {
        return $this->state;
    }

    public function getGuildId(): int
    {
        return $this->guildId;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPaperFloor(): string
    {
        return $this->paperFloor;
    }

    public function getPaperWall(): string
    {
        return $this->paperWall;
    }

    public function getPaperLandscape(): string
    {
        return $this->paperLandscape;
    }

    public function getThicknessWall(): int
    {
        return $this->thicknessWall;
    }

    public function getWallHeight(): int
    {
        return $this->wallHeight;
    }

    public function getThicknessFloor(): int
    {
        return $this->thicknessFloor;
    }

    public function getMoodlightData(): string
    {
        return $this->moodlightData;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function isStaffPicked(): bool
    {
        return $this->isStaffPicked;
    }

    public function allowPets(): bool
    {
        return $this->allowPets;
    }

    public function allowPetsEat(): bool
    {
        return $this->allowPetsEat;
    }

    public function allowWalkthrough(): bool
    {
        return $this->allowWalkthrough;
    }

    public function hideWall(): bool
    {
        return $this->hideWall;
    }

    public function getChatMode(): int
    {
        return $this->chatMode;
    }

    public function getChatWeight(): int
    {
        return $this->chatWeight;
    }

    public function getChatSpeed(): int
    {
        return $this->chatSpeed;
    }

    public function getChatDistance(): int
    {
        return $this->chatDistance;
    }

    public function getChatProtection(): int
    {
        return $this->chatProtection;
    }

    public function overrideModel(): bool
    {
        return $this->overrideModel;
    }

    public function getWhoCanMute(): int
    {
        return $this->whoCanMute;
    }

    public function getWhoCanKick(): int
    {
        return $this->whoCanKick;
    }

    public function getWhoCanBan(): int
    {
        return $this->whoCanBan;
    }

    public function getPollId(): int
    {
        return $this->pollId;
    }

    public function getRollerSpeed(): int
    {
        return $this->rollerSpeed;
    }

    public function isPromoted(): bool
    {
        return $this->isPromoted;
    }

    public function getTradeMode(): int
    {
        return $this->tradeMode;
    }

    public function canMoveDiagonally(): bool
    {
        return $this->canMoveDiagonally;
    }

    public function hasJukeboxActive(): bool
    {
        return $this->hasJukeboxActive;
    }

    public function hideWireds(): bool
    {
        return $this->hideWireds;
    }

    public function isForSale(): bool
    {
        return $this->isForSale;
    }
}