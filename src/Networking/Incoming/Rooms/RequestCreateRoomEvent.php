<?php

namespace Emulator\Networking\Incoming\Rooms;

use Emulator\Game\Navigator\NavigatorManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Game\Rooms\Handlers\CreateRoomHandler;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Game\Rooms\{RoomEnvironmentData,RoomManager};
use Emulator\Game\Utilities\Handlers\Enums\HandleTypeProcess;
use Emulator\Networking\Outgoing\Rooms\CanCreateRoomComposer;

class RequestCreateRoomEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $roomName = trim($message->readString());
        $roomDescription = $message->readString();
        $roomModelName = $message->readString();
        $roomCategoryId = $message->readInt();
        $maxUsers = $message->readInt();
        $tradeState = $message->readInt();

        $roomCategory = NavigatorManager::getInstance()->getFlatCategoryById($roomCategoryId);

        if(is_null($roomCategory) || $roomCategory->getMinRank() > $client->getUser()->getData()->getRank()) {
            RoomManager::getInstance()->getLogger()
                ->advertisement("[CAUTION] Room creation failed for user {$client->getUser()->getData()->getUsername()}. Possible script attempt.");

            return;
        }

        if(!RoomManager::getInstance()->getRoomModelsComponent()->roomModelExists($roomModelName)) {
            RoomManager::getInstance()->getLogger()
                ->advertisement("[CAUTION] Incorrect room model [{$roomModelName}] for user {$client->getUser()->getData()->getUsername()}. Possible script attempt.");
            return;
        }

        if($maxUsers > 250 || $tradeState > 2) return;

        if(strlen($roomName) < 3 || strlen($roomName) > 25 || strlen($roomDescription) > 128) return;

        $userRoomsCount = $client->getUser()->getRoomsComponent()->getOwnRooms()->count();
        $maximumRoomsAllowed = RoomEnvironmentData::$maximumRoomsAllowed;

        if($userRoomsCount >= $maximumRoomsAllowed) {
            $client->send(new CanCreateRoomComposer($userRoomsCount, $maximumRoomsAllowed));
            return;
        }

        CreateRoomHandler::dispatch(HandleTypeProcess::SingleProcess,
            $client, $roomName, $roomDescription, $roomModelName, $roomCategoryId, $maxUsers, $tradeState
        );
    }
    
    public function needsAuthentication(): bool
    {
        return true;
    }
}