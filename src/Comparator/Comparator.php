<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Override;

class Comparator implements Comparable
{
    public function __construct(private readonly Collator $collator)
    {
    }

    #[Override]
    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return $this->collator->compare($value, $comparativeValue);
    }
}
