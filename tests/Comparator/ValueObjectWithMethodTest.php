<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Comparator\ValueObject;
use Collator;

class ValueObjectWithMethodTest extends ValueObjectTest
{
    protected function createComparator(Collator $collator): ValueObject
    {
        return new ValueObject($collator, 'foo', false);
    }

    /**
     * {@inheritDoc}
     */
    protected function createObject($value): object
    {
        return new class ($value) {
            /** @var int|string */
            private $value;

            /**
             * @param int|string $value
             */
            public function __construct($value)
            {
                $this->value = $value;
            }

            /**
             * @return int|string
             */
            public function foo()
            {
                return $this->value;
            }
        };
    }
}
