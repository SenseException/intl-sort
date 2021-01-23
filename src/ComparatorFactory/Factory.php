<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Comparator\Comparable;
use Collator;

interface Factory
{
    public function create(Collator $collator): Comparable;
}
