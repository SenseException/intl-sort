<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory\Fixtures;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\CollatorConstructor;

class Foo implements CollatorConstructor
{
    public function __construct(private Collator $collator)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return $this->collator->compare($value, $comparativeValue);
    }
}
