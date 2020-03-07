<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

interface Sorter
{
    public function sort(array $values) : iterable;
}