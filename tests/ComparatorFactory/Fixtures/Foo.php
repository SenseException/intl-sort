<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory\Fixtures;

use Budgegeria\IntlSort\Comparator\CollatorConstructor;
use Collator;

class Foo implements CollatorConstructor
{
    /** @var Collator */
    private $collator;

    public function __construct(Collator $collator)
    {
        $this->collator = $collator;
    }

    /**
     * {@inheritDoc}
     */
    public function compare($value, $comparativeValue): int
    {
        return (int) $this->collator->compare($value, $comparativeValue);
    }
}
