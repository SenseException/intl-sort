<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Exception\IntlSortException;

interface CollatorConstructor extends Comparable
{
    /** @throws IntlSortException */
    public function __construct(Collator $collator);
}
