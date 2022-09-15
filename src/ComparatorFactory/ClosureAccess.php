<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\ClosureAccess as Comparator;
use Budgegeria\IntlSort\Comparator\Comparable;
use Closure;

class ClosureAccess implements Factory
{
    /** @psalm-param Closure(mixed):string $func */
    public function __construct(private Closure $func)
    {
    }

    public function create(Collator $collator): Comparable
    {
        return new Comparator($collator, $this->func);
    }
}
