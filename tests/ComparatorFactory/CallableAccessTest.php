<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\CallableAccess;
use Budgegeria\IntlSort\ComparatorFactory\CallableAccess as Factory;
use PHPUnit\Framework\TestCase;

class CallableAccessTest extends TestCase
{
    public function testCreateForMethod(): void
    {
        $func       = static fn (mixed $value): string => (string) $value;
        $collator   = $this->createStub(Collator::class);
        $factory    = new Factory($func);
        $comparator = new CallableAccess($collator, $func);

        self::assertEquals($comparator, $factory->create($collator));
    }
}
