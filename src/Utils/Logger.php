<?php

namespace Emulator\Utils;

use function Termwind\{render};

class Logger
{
    public readonly string $completeClass;
    public readonly string $className;

    public function __construct(string $completeClass) {
        $this->completeClass = $completeClass;
        
        $this->className = (
            new \ReflectionClass($completeClass)
        )->getShortName();
    }

    public function warning(string $message): void
    {
        render(<<<HTML
            <div>
                <div class="px-1 mr-1 bg-yellow-600 text-black">
                    <span class="font-bold">$this->className</span>
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
                    <span class="font-bold">$this->className</span>
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
                    <span class="font-bold">$this->className</span>
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
                    <span class="font-bold">$this->className</span>
                </div>
                <span class="text-white">$message</span>
            </div>
        HTML);
    }
}