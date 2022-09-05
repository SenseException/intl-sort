<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Closure;

class ClosureAccess implements Comparable
{
    public function __construct(private Collator $collator, private Closure $func)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return 0;
    }
}
