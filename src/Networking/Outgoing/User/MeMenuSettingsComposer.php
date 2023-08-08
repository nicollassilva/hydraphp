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

        $this->writeInt($settings->getVolumeSystem());
        $this->writeInt($settings->getVolumeFurni());
        $this->writeInt($settings->getVolumeTrax());
        $this->writeBoolean($settings->getPreferOldChat());
        $this->writeBoolean($settings->getBlockRoomInvites());
        $this->writeBoolean($settings->getBlockCameraFollow());
        $this->writeInt($settings->getUiFlags());
        $this->writeInt($settings->getChatColor()?->getType() ?? 0);
    }
}