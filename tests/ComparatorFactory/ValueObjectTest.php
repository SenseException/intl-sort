<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory;

use Budgegeria\IntlSort\Comparator\ValueObject;
use Budgegeria\IntlSort\ComparatorFactory\ValueObject as Factory;
use Collator;
use PHPUnit\Framework\TestCase;

class ValueObjectTest extends TestCase
{
    public function testCreateForMethod(): void
    {
        $collator   = $this->createStub(Collator::class);
        $factory    = new Factory('foo');
        $comparator = new ValueObject($collator, 'foo', false);

        self::assertEquals($comparator, $factory->create($collator));
    }

    public function testCreateForProperty(): void
    {
        $collator   = $this->createStub(Collator::class);
        $factory    = new Factory('foo', true);
        $comparator = new ValueObject($collator, 'foo', true);

        self::assertEquals($comparator, $factory->create($collator));
    }
}
