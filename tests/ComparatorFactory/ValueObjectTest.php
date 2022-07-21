<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\ValueObject;
use Budgegeria\IntlSort\ComparatorFactory\ValueObject as Factory;
use PHPUnit\Framework\TestCase;

class ValueObjectTest extends TestCase
{
    public function testCreateForMethod(): void
    {
        $collator   = $this->createStub(Collator::class);
        $factory    = Factory::createForMethodCall('foo');
        $comparator = new ValueObject($collator, 'foo', false);

        self::assertEquals($comparator, $factory->create($collator));
    }

    public function testCreateForProperty(): void
    {
        $collator   = $this->createStub(Collator::class);
        $factory    = Factory::createForPropertyCall('foo');
        $comparator = new ValueObject($collator, 'foo', true);

        self::assertEquals($comparator, $factory->create($collator));
    }
}
