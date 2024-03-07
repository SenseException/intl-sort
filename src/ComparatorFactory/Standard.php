<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Comparator\Comparator;
use Override;

class Standard implements Factory
{
    #[Override]
    public function create(Collator $collator): Comparable
    {
        return new Comparator($collator);
    }
}
