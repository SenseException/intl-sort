<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Comparator\ValueObject;
use Collator;

class ValueObjectWithPropertyTest extends ValueObjectTest
{
    protected function createComparator(Collator $collator): ValueObject
    {
        return new ValueObject($collator, 'foo', true);
    }

    /**
     * {@inheritDoc}
     */
    protected function createObject($value): object
    {
        return new class ($value) {
            /** @var int|string */
            public $foo;

            /**
             * @param int|string $value
             */
            public function __construct($value)
            {
                $this->foo = $value;
            }
        };
    }
}
