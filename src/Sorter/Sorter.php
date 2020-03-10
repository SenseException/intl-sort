<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;

interface Sorter
{
    /**
     * @param array<int|string> $values
     * @throws IntlSortException
     * @return array<int|string>
     */
    public function sort(array $values) : array;
}