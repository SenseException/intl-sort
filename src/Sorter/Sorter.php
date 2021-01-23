<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;

interface Sorter
{
    /**
     * @param array<int|string> $values
     *
     * @return array<int|string>
     *
     * @throws IntlSortException
     */
    public function sort(array $values): array;
}
