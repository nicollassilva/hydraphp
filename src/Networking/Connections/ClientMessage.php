<?php

namespace Emulator\Networking\Connections;

use Emulator\Utils\Services\EncodingService;

class ClientMessage
{
    private int $header;
    private int $length;
    private string $currentPackage;

    public function __construct(
        private readonly string $originalPackage
    ) {
        $this->currentPackage = $originalPackage;

        $this->readLength();
        $this->readHeader();
    }

    private function readLength(): int {
        $this->length = EncodingService::decode32Byte($this->currentPackage);
        $this->resetStringOn(4);

        return $this->length;
    }

    private function readHeader(): int {
        $this->header = EncodingService::decode16Byte($this->currentPackage);
        $this->resetStringOn(2);

        return $this->header;
    }

    private function resetStringOn(int $length): void {
        $this->currentPackage = substr($this->currentPackage, $length);
    }

    public function readString() {
        $length = EncodingService::decode16Byte($this->currentPackage);
        $string = substr($this->currentPackage, 2, $length);
        $this->resetStringOn($length + 2);

        return $string;
    }

    public function readBoolean() {
        $boolean = !(ord($this->currentPackage[0]) == 0);
        $this->resetStringOn(1);

        return $boolean;
    }

    public function readInt32() {
        $int = EncodingService::decode32Byte($this->currentPackage);
        $this->resetStringOn(4);

        return $int;
    }

    public function readInt16() {
        $int = EncodingService::decode16Byte($this->currentPackage);
        $this->resetStringOn(2);

        return $int;
    }

    public function getHeader(): int {
        return $this->header;
    }

    public function getLength(): int {
        return $this->header;
    }

    public function getCurrentPacket(): string {
        return $this->currentPackage;
    }

    public function getOriginalPacket(): string {
        return $this->originalPackage;
    }
}