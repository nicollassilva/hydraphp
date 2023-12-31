<?php

namespace Emulator\Api\Game\Catalog\Layouts;

use Emulator\Api\Networking\Outgoing\IMessageComposer;
use Emulator\Api\Game\Catalog\Data\ICatalogFeaturedPage;

interface ICatalogFrontPage extends ICatalogLayout
{
    public static function composeFrontPage(IMessageComposer $message, ICatalogFeaturedPage &$page): void;
}