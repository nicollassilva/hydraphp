<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Game\Rooms\Enums\RoomRightLevels;
use Emulator\Game\Rooms\Enums\RoomEntityStatus;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Rooms\RoomDataComposer;
use Emulator\Networking\Outgoing\Rooms\RoomPaneComposer;
use Emulator\Networking\Outgoing\Rooms\RoomOwnerComposer;
use Emulator\Networking\Outgoing\Rooms\RoomUsersComposer;
use Emulator\Networking\Outgoing\Rooms\RoomRightsComposer;
use Emulator\Networking\Outgoing\Rooms\RoomThicknessComposer;
use Emulator\Networking\Outgoing\Rooms\RoomWallItemsComposer;
use Emulator\Networking\Outgoing\Rooms\RoomFloorItemsComposer;
use Emulator\Networking\Outgoing\Rooms\RoomRightsListComposer;
use Emulator\Networking\Outgoing\Rooms\RoomUserStatusComposer;
use Emulator\Networking\Outgoing\Rooms\RoomGroupBadgesComposer;

class RequestHeightmapEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $userEntity = $client->getUser()->getEntity();

        if(!$userEntity || !$userEntity->getRoom()) return;

        $room = $userEntity->getRoom();

        $userEntity->removeStatus(RoomEntityStatus::FlatCtrl);

        $flatCtrl = RoomRightLevels::None;

        if($room->isOwner($client->getUser())) {
            $client->getUser()->getClient()->send(new RoomOwnerComposer);
            $flatCtrl = RoomRightLevels::Moderator;
        }
        
        $userEntity->setStatus(RoomEntityStatus::FlatCtrl, $flatCtrl->value);
        $userEntity->setRoomRightLevel($flatCtrl);
        
        $client->send(new RoomRightsComposer($flatCtrl));

        if($flatCtrl->value == RoomRightLevels::Moderator->value) {
            $client->send(new RoomRightsListComposer($room));
        }
        
        $client->send(new RoomUsersComposer($client->getUser()))
            ->send(new RoomUserStatusComposer($userEntity))
            ->send(new RoomPaneComposer($room, $room->isOwner($client->getUser())))
            ->send(new RoomThicknessComposer($room))
            ->send(new RoomDataComposer($room, $client->getUser(), false, true))
            ->send(new RoomWallItemsComposer($room))
            ->send(new RoomFloorItemsComposer($room))
            ->send(new RoomGroupBadgesComposer);
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}