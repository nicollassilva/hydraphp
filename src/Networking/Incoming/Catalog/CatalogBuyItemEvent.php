<?php

namespace Emulator\Networking\Incoming\Catalog;

use Carbon\Carbon;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Catalog\CatalogEnvironmentData;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Game\Utilities\Enums\MiddleAlertKeyTypes;
use Emulator\Game\Catalog\Handlers\CatalogPurchaseHandler;
use Emulator\Game\Utilities\Handlers\Enums\HandleTypeProcess;

class CatalogBuyItemEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $pageId = $message->readInt();
        $itemId = $message->readInt();
        $extraData = $message->readString();
        $amount = min(max($message->readInt(), 1), 100);

        $cooldownTime = Carbon::now()->addMinutes(CatalogEnvironmentData::$cooldownToBuyItems);

        if($client->getUser()->getData()->getLastPurchaseTime()->gt($cooldownTime)) {
            $client->sendMiddleAlert(MiddleAlertKeyTypes::ADMIN_PERSISTENT, 'You are purchasing items too fast. Please wait a few seconds and try again.');
            return;
        }

        if(!$client->getUser()->getSettings()->getAllowTrade()) {
            $client->sendMiddleAlert(MiddleAlertKeyTypes::ADMIN_PERSISTENT, 'Trading is disabled for your account.');
            return;
        }

        CatalogPurchaseHandler::dispatch(HandleTypeProcess::SingleProcess,
            $client, $pageId, $itemId, $extraData, $amount
        );
    }

    public function needsAuthentication(): bool
    {
        return true;
    }
}