<?php

namespace Emulator\Game\Rooms\Handlers;

use Emulator\Hydra;
use Emulator\Utils\Logger;
use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Rooms\RoomManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Rooms\Types\Entities\UserEntity;
use Emulator\Game\Utilities\Handlers\AbstractHandler;
use Emulator\Game\Utilities\Handlers\Enums\HandleTypeProcess;
use Emulator\Game\Rooms\Enums\{RoomRightLevels, RoomEntityStatus};
use Emulator\Networking\Outgoing\Rooms\{RoomPaneComposer, RoomOwnerComposer, RoomPaintComposer, RoomScoreComposer, RoomUsersComposer, RoomRightsComposer, HideDoorbellComposer, RoomPromotionComposer, RoomThicknessComposer, RoomWallItemsComposer, RoomUserStatusComposer, RoomFloorItemsComposer, RoomRightsListComposer, RoomGroupBadgesComposer};

/** @property Logger $logger */
class JoinRoomHandler extends AbstractHandler
{
    public function handle(HandleTypeProcess $handleTypeProcess, ...$params): void
    {
        match ($handleTypeProcess) {
            HandleTypeProcess::FirstProcess => $this->sendInitialRoomData(...$params),
            HandleTypeProcess::SecondProcess => $this->finalizeRoomJoin(...$params),
            default => $this->getLogger()->warning("Unhandled handle type process.")
        };
    }

    private function sendInitialRoomData(IUser $user, int $roomId, string $password, bool $bypassPermissionVerifications = false): void
    {
        $room = RoomManager::getInstance()->loadRoom($roomId);

        if (empty($room)) {
            if (Hydra::$isDebugging) $this->getLogger()->warning("Room not found: {$roomId}.");

            return;
        }

        if (empty($room->getModel())) {
            if (Hydra::$isDebugging) $this->getLogger()->warning("Room model not found: {$roomId}.");

            return;
        }

        $user->getClient()->send(new HideDoorbellComposer(""));

        if ($user->getEntity()) {
            $user->getEntity()->dispose();
            $user->setEntity(null);
        }

        $userEntity = $user->setEntity(new UserEntity($room->getNextEntityId(), $user, $room));

        if (!$userEntity) {
            if (Hydra::$isDebugging) $this->getLogger()->warning("User entity not created for user {$user->getData()->getUsername()}.");

            return;
        }

        $userEntity->clearStatus();

        $user->getClient()->send(new RoomPaintComposer($room));

        $flatCtrl = RoomRightLevels::None;

        if ($room->isOwner($user)) {
            $user->getClient()->send(new RoomOwnerComposer);
            $flatCtrl = RoomRightLevels::Moderator;
        }

        $userEntity->setStatus(RoomEntityStatus::FlatCtrl, $flatCtrl->value);
        $userEntity->setRoomRightLevel($flatCtrl);

        $user->getClient()->send(new RoomRightsComposer($flatCtrl));

        if ($flatCtrl->value == RoomRightLevels::Moderator->value) {
            $user->getClient()->send(new RoomRightsListComposer($room));
        }

        $room->getEntityComponent()->addUserEntity($userEntity);

        $user->getClient()
            ->send(new RoomScoreComposer($room))
            ->send(new RoomPromotionComposer);
    }

    private function finalizeRoomJoin(IClient $client): void
    {
        $userEntity = $client->getUser()->getEntity();

        if (!$userEntity || !$userEntity->getRoom()) return;

        $room = $userEntity->getRoom();

        $userEntity->removeStatus(RoomEntityStatus::FlatCtrl);

        $flatCtrl = RoomRightLevels::None;

        if ($room->isOwner($client->getUser())) {
            $client->getUser()->getClient()->send(new RoomOwnerComposer);
            $flatCtrl = RoomRightLevels::Moderator;
        }

        $userEntity->setStatus(RoomEntityStatus::FlatCtrl, $flatCtrl->value);
        $userEntity->setRoomRightLevel($flatCtrl);

        $client->send(new RoomRightsComposer($flatCtrl));

        if ($flatCtrl->value == RoomRightLevels::Moderator->value) {
            $client->send(new RoomRightsListComposer($room));
        }

        if (!$room->getProcessComponent()->started()) {
            $room->getProcessComponent()->start();
        }

        $room->broadcastMessage(new RoomUsersComposer(null, $userEntity));

        $client->send(new RoomUsersComposer($room->getEntityComponent()->getUserEntities()))
            ->send(new RoomUserStatusComposer($room->getEntityComponent()->getUserEntities()))
            ->send(new RoomPaneComposer($room, $room->isOwner($client->getUser())))
            ->send(new RoomThicknessComposer($room))
            ->send(new RoomWallItemsComposer($room))
            ->send(new RoomFloorItemsComposer($room))
            ->send(new RoomGroupBadgesComposer);
    }
}