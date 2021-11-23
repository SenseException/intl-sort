<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Collator;
use Budgegeria\IntlSort\Comparator\ValueObject;

class ValueObjectWithPropertyTest extends ValueObjectTest
{
    protected function createComparator(Collator $collator): ValueObject
    {
        return new ValueObject($collator, 'foo', true);
    }

    protected function createObject(int|string $value): object
    {
        return new class ($value) {
            public function __construct(public int|string $foo)
            {
            }
        };
    }
}
