<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Comparator\ValueObject;
use Budgegeria\IntlSort\Tests\Collator as CollatorTrait;
use Collator;

class ValueObjectWithPropertyTest extends ValueObjectTest
{
    use CollatorTrait;

    protected function createComparator(Collator $collator): ValueObject
    {
        return new ValueObject($this->createCollator($collator), 'foo', true);
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
