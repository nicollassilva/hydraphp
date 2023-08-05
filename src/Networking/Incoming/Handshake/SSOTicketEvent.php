<?php

namespace Emulator\Networking\Incoming\Handshake;

use Emulator\Game\Users\Requests\LoginRequest;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Emulator\PingComposer;
use Emulator\Networking\Outgoing\User\UserClubComposer;
use Emulator\Networking\Outgoing\User\CfhTopicsComposer;
use Emulator\Networking\Outgoing\User\UserHomeRoomComposer;
use Emulator\Networking\Outgoing\User\MysteryBoxKeysComposer;
use Emulator\Networking\Outgoing\Inventory\UserClothesComposer;
use Emulator\Networking\Outgoing\User\IsFirstLoginOfDayComposer;
use Emulator\Networking\Outgoing\Handshake\SecureLoginOkComposer;
use Emulator\Networking\Outgoing\User\FavoriteRoomsCountComposer;
use Emulator\Networking\Outgoing\User\BuildersClubExpiredComposer;
use Emulator\Networking\Outgoing\User\EnableNotificationsComposer;
use Emulator\Networking\Outgoing\Inventory\NewUserIdentityComposer;
use Emulator\Networking\Outgoing\Inventory\UserPermissionsComposer;
use Emulator\Networking\Outgoing\Inventory\InventoryEffectsComposer;
use Emulator\Networking\Outgoing\Inventory\InventoryRefreshComposer;
use Emulator\Networking\Outgoing\User\InventoryAchievementsComposer;
use Emulator\Networking\Outgoing\User\UserAchievementsScoreComposer;
use Emulator\Networking\Outgoing\Emulator\AvailabilityStatusComposer;
use Emulator\Networking\Outgoing\HotelView\AdventCalendarDataComposer;

class SSOTicketEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $ticket = $message->readString();

        $loginRequest = new LoginRequest($client, $ticket);

        if(!$loginRequest->isValid()) {
            $client->getLogger()->warning('Invalid SSO ticket length: ' . $loginRequest->getTicketLength());
            $client->disconnect();
            return;
        }

        if(!$loginRequest->attemptLogin()) {
            $client->getLogger()->warning('Failed to login user with ticket: ' . $ticket);
            $client->disconnect();
            return;
        }

        $client->send(new SecureLoginOkComposer)
            ->send(new InventoryEffectsComposer)
            ->send(new UserClothesComposer)
            ->send(new NewUserIdentityComposer)
            ->send(new UserPermissionsComposer)
            ->send(new AvailabilityStatusComposer)
            ->send(new PingComposer)
            ->send(new EnableNotificationsComposer)
            ->send(new UserAchievementsScoreComposer)
            ->send(new IsFirstLoginOfDayComposer)
            ->send(new MysteryBoxKeysComposer)
            ->send(new BuildersClubExpiredComposer)
            ->send(new CfhTopicsComposer)
            ->send(new FavoriteRoomsCountComposer)
            ->send(new AdventCalendarDataComposer)
            ->send(new UserClubComposer)
            ->send(new InventoryRefreshComposer)
            ->send(new InventoryAchievementsComposer)
            ->send(new UserHomeRoomComposer);
    }
}