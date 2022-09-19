<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Closure;

class CallableAccess implements Comparable
{
    /** @psalm-var Closure(mixed):string */
    private Closure $func;

    /** @psalm-param callable(mixed):string $func */
    public function __construct(private Collator $collator, callable $func)
    {
        $this->func = Closure::fromCallable($func);
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return $this->collator->compare(
            ($this->func)($value),
            ($this->func)($comparativeValue),
        );
    }
}
