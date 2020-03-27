<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

interface Comparable
{
    public function compare(string $value, string $comparativeValue): Result;
}