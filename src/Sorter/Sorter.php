<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;

interface Sorter
{
    /**
     * @param array<int|string, int|string|object|null> $values
     *
     * @return array<int|string, int|string|object|null>
     *
     * @throws IntlSortException
     */
    public function sort(array $values): array;
}
