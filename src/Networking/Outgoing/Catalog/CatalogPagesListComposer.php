<?php

namespace Emulator\Networking\Outgoing\Catalog;

use Emulator\Api\Game\Users\IUser;
use Emulator\Game\Catalog\CatalogManager;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class CatalogPagesListComposer extends MessageComposer
{
    public function __construct(IUser $user, string $mode)
    {
        $this->header = OutgoingHeaders::$catalogPagesListComposer;

        $pages = CatalogManager::getInstance()->getPages();

        $this->writeBoolean(true);
        $this->writeInt(0);
        $this->writeInt(-1);
        $this->writeString("root");
        $this->writeString("");
        $this->writeInt(0);
        $this->writeInt(count($pages));

        foreach($pages as $page) {

        }

        $this->writeBoolean(false);
        $this->writeString($mode);
    }
}