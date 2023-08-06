<?php

namespace Emulator\Networking\Outgoing\User;

use Emulator\Api\Game\Users\Data\IUserSettings;
use Emulator\Networking\Outgoing\MessageComposer;
use Emulator\Networking\Outgoing\OutgoingHeaders;

class MeMenuSettingsComposer extends MessageComposer
{
    public function __construct(IUserSettings $settings)
    {
        $this->header = OutgoingHeaders::$meMenuSettingsComposer;

        $this->writeInt32($settings->getVolumeSystem());
        $this->writeInt32($settings->getVolumeFurni());
        $this->writeInt32($settings->getVolumeTrax());
        $this->writeBoolean($settings->getPreferOldChat());
        $this->writeBoolean($settings->getBlockRoomInvites());
        $this->writeBoolean($settings->getBlockCameraFollow());
        $this->writeInt32($settings->getUiFlags());
        $this->writeInt32($settings->getChatColor()?->getType() ?? 0);
    }
}