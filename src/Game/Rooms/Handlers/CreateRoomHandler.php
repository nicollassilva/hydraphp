<?php

namespace Emulator\Game\Rooms\Handlers;

use Emulator\Utils\Logger;
use Emulator\Api\Game\Rooms\IRoom;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Utilities\Handlers\AbstractHandler;
use Emulator\Storage\Repositories\Rooms\RoomRepository;
use Emulator\Networking\Outgoing\Rooms\RoomCreatedComposer;
use Emulator\Game\Utilities\Handlers\Enums\HandleTypeProcess;

/** @property Logger $logger */
class CreateRoomHandler extends AbstractHandler
{
    public function handle(HandleTypeProcess $handleTypeProcess, ...$params): void
    {
        match ($handleTypeProcess) {
            HandleTypeProcess::SingleProcess => $this->createRoom(...$params),
            default => $this->getLogger()->warning("Unhandled handle type process.")
        };
    }

    private function createRoom(
        IClient $client,
        string $roomName,
        string $roomDescription,
        string $roomModelName,
        int $roomCategoryId,
        int $maxUsers,
        int $tradeState
    ): void {
        $room = null;
        
        RoomRepository::createRoomForUser(
            $client->getUser(),
            $roomName,
            $roomDescription,
            $roomModelName,
            $roomCategoryId,
            $maxUsers,
            $tradeState,
            $room
        );

        if(!($room instanceof IRoom)) {
            $this->getLogger()->error("Failed to create room for user {$client->getUser()->getData()->getUsername()}.");
            return;
        }

        $client->getUser()->getRoomsComponent()->addOwnRoom($room);
        
        $client->send(new RoomCreatedComposer($room->getData()->getId(), $room->getData()->getName()));
    }
}