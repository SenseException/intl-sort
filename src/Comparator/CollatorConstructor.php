<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator as IntlCollator;

interface CollatorConstructor extends Comparable
{
    /**
     * @throws IntlSortException
     */
    public function __construct(IntlCollator $collator);
}