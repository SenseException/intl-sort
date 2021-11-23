<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Comparator\ValueObject as Comparator;
use Collator;

class ValueObject implements Factory
{
    public function __construct(private string $methodOrPropertyName, private bool $isProperty = false)
    {
    }

    public function create(Collator $collator): Comparable
    {
        return new Comparator($collator, $this->methodOrPropertyName, $this->isProperty);
    }
}
