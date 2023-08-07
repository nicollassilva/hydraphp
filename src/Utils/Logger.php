<?php

namespace Emulator\Utils;

use function Termwind\{render};

class Logger
{
    public readonly string $name;

    public function __construct(string $name, bool $nameIsClassName = true)
    {
        $this->name = $nameIsClassName ? (
            new \ReflectionClass($name)
        )->getShortName() : $name;
    }

    public function warning(string $message): void
    {
        render(<<<HTML
            <div>
                <div class="px-1 mr-1 bg-yellow-600 text-black">
                    <span class="font-bold">$this->name</span>
                </div>
                <span class="text-white">$message</span>
            </div>
        HTML);
    }

    public function error(string $message): void
    {
        render(<<<HTML
            <div>
                <div class="px-1 mr-1 bg-red-600 text-white">
                    <span class="font-bold">$this->name</span>
                </div>
                <span class="text-white">$message</span>
            </div>
        HTML);
    }

    public function info(string $message): void
    {
        render(<<<HTML
            <div>
                <div class="px-1 mr-1 bg-sky-600 text-black">
                    <span class="font-bold">$this->name</span>
                </div>
                <span class="text-white">$message</span>
            </div>
        HTML);
    }

    public function success(string $message): void
    {
        render(<<<HTML
            <div>
                <div class="px-1 mr-1 bg-green-500 text-black">
                    <span class="font-bold">$this->name</span>
                </div>
                <span class="text-white">$message</span>
            </div>
        HTML);
    }

    public function advertisement(string $message): void
    {
        render(<<<HTML
            <div>
                <div class="px-1 mr-1 bg-orange-500 text-black">
                    <span class="font-bold">$this->name</span>
                </div>
                <span class="text-white">$message</span>
            </div>
        HTML);
    }
}