<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Collator;
use Budgegeria\IntlSort\Collator\ConfigurableCollator;
use Budgegeria\IntlSort\Collator\Configuration;
use Budgegeria\IntlSort\Comparator\ValueObject;

class ValueObjectWithMethodTest extends ValueObjectTest
{
    protected function createComparator(Collator $collator): ValueObject
    {
        return new ValueObject(new ConfigurableCollator($collator, new Configuration()), 'foo', false);
    }

    protected function createObject(int|string $value): object
    {
        return new class ($value) {
            public function __construct(private int|string $value)
            {
            }

            public function foo(): int|string
            {
                return $this->value;
            }
        };
    }
}
