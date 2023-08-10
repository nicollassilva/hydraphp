<?php

namespace Emulator\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Game\Catalog\Layouts\ICatalogLayout;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

abstract class InfoRentablesLayout implements ICatalogLayout
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage &$page): void
    {
        $data = explode("\\|\\|", $page->getPageText1());
        
        $message->writeString("info_rentables");
        $message->writeInt(1);
        $message->writeString($page->getPageHeadline());
        $message->writeInt(count($data));

        foreach ($data as $line) {
            $message->writeString($line);
        }

        $message->writeInt(0);
    }
}