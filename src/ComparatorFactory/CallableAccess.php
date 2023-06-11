<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\CallableAccess as Comparator;
use Budgegeria\IntlSort\Comparator\Comparable;
use Closure;

class CallableAccess implements Factory
{
    /** @psalm-var Closure(mixed):string */
    private readonly Closure $func;

    /** @psalm-param callable(mixed):string $func */
    public function __construct(callable $func)
    {
        $this->func = $func(...);
    }

    public function create(Collator $collator): Comparable
    {
        return new Comparator($collator, $this->func);
    }
}
