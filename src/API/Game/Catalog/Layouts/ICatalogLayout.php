<?php

namespace Emulator\Api\Game\Catalog\Layouts;

use Emulator\Api\Game\Catalog\Data\ICatalogPage;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

interface ICatalogLayout
{
    public static function composeLayout(IMessageComposer $message, ICatalogPage &$page): void;
}