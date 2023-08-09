<?php

namespace Emulator\Networking\Incoming\Catalog;

use Emulator\Game\Catalog\CatalogManager;
use Emulator\Api\Networking\Connections\IClient;
use Emulator\Networking\Connections\ClientMessage;
use Emulator\Api\Networking\Incoming\IIncomingMessage;
use Emulator\Networking\Outgoing\Catalog\CatalogPageComposer;

class RequestCatalogPageEvent implements IIncomingMessage
{
    public function handle(IClient $client, ClientMessage $message): void
    {
        $pageId = $message->readInt();
        $offerId = $message->readInt();
        $mode = $message->readString();

        $catalogPage = CatalogManager::getInstance()->getPageById($pageId);

        if(!$catalogPage->isEnabled()) return;

        if($client->getUser()->getData()->getRank() < $catalogPage->getMinRank()) return;

        if(!$catalogPage->isVisible()) {
            $client->getUser()->getEntity()->getLogger()->error("Scripter detected! User tried to access a hidden catalog page!");
            return;
        }

        $client->send(new CatalogPageComposer($catalogPage, $client->getUser(), $offerId, $mode));
    }

    public function needsAuthentication(): bool
    {
        return true;
    }
}