<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;

class Comparator implements Comparable
{
    public function __construct(private readonly Collator $collator)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return $this->collator->compare($value, $comparativeValue);
    }
}
