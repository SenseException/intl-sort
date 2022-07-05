<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Comparator\Comparator;

class Standard implements Factory
{
    public function create(Collator $collator): Comparable
    {
        return new Comparator($collator);
    }
}
