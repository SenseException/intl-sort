<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Closure;
use Override;

class CallableAccess implements Comparable
{
    /** @psalm-var Closure(mixed):string */
    private readonly Closure $func;

    /** @psalm-param callable(mixed):string $func */
    public function __construct(private readonly Collator $collator, callable $func)
    {
        $this->func = $func(...);
    }

    #[Override]
    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return $this->collator->compare(
            ($this->func)($value),
            ($this->func)($comparativeValue),
        );
    }
}
