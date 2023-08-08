<?php

namespace Emulator\Api\Networking\Outgoing;

interface IMessageComposer
{
    public function getHeader(): int;
    
    public function writeInt(int $value): IMessageComposer;
    public function writeShort(float $value): IMessageComposer;
    public function writeString(string $value): IMessageComposer;
    public function writeBoolean(bool $value): IMessageComposer;

    public function compose(): string;
}