<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Exception\IntlSortException;

/** @deprecated This class is deprecated and will be removed in 3.0. Please use Budgegeria\IntlSort\Comparator\CallableAccess instead */
interface CollatorConstructor extends Comparable
{
    /** @throws IntlSortException */
    public function __construct(Collator $collator);
}
