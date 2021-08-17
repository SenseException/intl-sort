<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;

interface Sorter
{
    /**
     * @param array<int|string|null> $values
     *
     * @return array<int|string|null>
     *
     * @throws IntlSortException
     */
    public function sort(array $values): array;
}
