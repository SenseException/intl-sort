<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Closure;

class ClosureAccess implements Comparable
{
    /** @psalm-param Closure(mixed):string $func */
    public function __construct(private Collator $collator, private Closure $func)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return $this->collator->compare(
            ($this->func)($value),
            ($this->func)($comparativeValue),
        );
    }
}
