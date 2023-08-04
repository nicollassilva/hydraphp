<?php

namespace Emulator\Networking\Outgoing;

use Emulator\Utils\Services\EncodingService;
use Emulator\Api\Networking\Outgoing\IMessageComposer;

class MessageComposer implements IMessageComposer
{
    protected int $header = 0;
    private string $packageData = '';

    public function getHeader(): int
    {
        return $this->header;
    }

    public function writeInt32(int $value): IMessageComposer
    {
        $this->packageData .= EncodingService::encode32Byte($value);

        return $this;
    }

    public function writeInt16(int $value): IMessageComposer
    {
        $this->packageData .= EncodingService::encode16Byte($value);

        return $this;
    }

    public function writeString(string $value): IMessageComposer
    {
        $this->packageData .= EncodingService::encodeString($value);

        return $this;
    }

    public function writeBoolean(bool $value): IMessageComposer
    {
        $this->packageData .= EncodingService::encodeBoolean($value);

        return $this;
    }

    public function compose(): string
    {
        return sprintf('%s%s%s',
            EncodingService::encode32Byte(strlen($this->packageData) + 2),
            EncodingService::encode16Byte($this->getHeader()),
            $this->packageData
        );
    }
}