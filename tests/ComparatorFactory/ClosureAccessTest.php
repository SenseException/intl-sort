<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\ClosureAccess;
use Budgegeria\IntlSort\ComparatorFactory\ClosureAccess as Factory;
use PHPUnit\Framework\TestCase;

class ClosureAccessTest extends TestCase
{
    public function testCreateForMethod(): void
    {
        $func       = static fn (mixed $value): string => (string) $value;
        $collator   = $this->createStub(Collator::class);
        $factory    = new Factory($func);
        $comparator = new ClosureAccess($collator, $func);

        self::assertEquals($comparator, $factory->create($collator));
    }
}
