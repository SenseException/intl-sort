<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

interface Result
{
    public function isSame(): bool;

    public function isGreater(): bool;

    public function isLess(): bool;
}