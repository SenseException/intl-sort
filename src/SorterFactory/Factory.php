<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\SorterFactory;

use Budgegeria\IntlSort\Sorter\Sorter;
use Collator;

interface Factory
{
    public function createSorter(Collator $collator): Sorter;
}