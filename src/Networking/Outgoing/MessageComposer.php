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

    public function writeInt(int $value): IMessageComposer
    {
        $this->packageData .= EncodingService::encodeInteger($value);

        return $this;
    }

    public function writeShort(float $value): IMessageComposer
    {
        $this->packageData .= EncodingService::encodeShort($value);

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
            EncodingService::encodeInteger(strlen($this->packageData) + 2),
            EncodingService::encodeShort($this->getHeader()),
            $this->packageData
        );
    }
}