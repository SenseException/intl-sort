<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory\Fixtures;

use Budgegeria\IntlSort\Comparator\CollatorConstructor;
use Collator;

class Foo implements CollatorConstructor
{
    public function __construct(private Collator $collator)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return (int) $this->collator->compare($value, $comparativeValue);
    }
}
