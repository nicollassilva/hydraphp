<?php

namespace Emulator\Game\Navigator\Data;

use Emulator\Game\Navigator\Enums\NavigatorFilterComparator;

class NavigatorFilterField
{
    public function __construct(
        private readonly string $key,
        private readonly string $field,
        private readonly NavigatorFilterComparator $comparator,
        private readonly string $query
    ) {}

    public function getKey(): string
    {
        return $this->key;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getComparator(): NavigatorFilterComparator
    {
        return $this->comparator;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}