<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Exception\IntlSortException;

interface Comparable
{
    /**
     * @throws IntlSortException
     */
    public function compare(mixed $value, mixed $comparativeValue): int;
}
