<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Exception\IntlSortException;

interface Comparable
{
    /**
     * @param mixed $value
     * @param mixed $comparativeValue
     *
     * @throws IntlSortException
     */
    public function compare($value, $comparativeValue): int;
}
