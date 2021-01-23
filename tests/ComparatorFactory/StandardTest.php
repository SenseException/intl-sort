<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory;

use Budgegeria\IntlSort\Comparator\Comparator;
use Budgegeria\IntlSort\ComparatorFactory\Standard;
use Collator;
use PHPUnit\Framework\TestCase;

class StandardTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new Standard();

        self::assertInstanceOf(Comparator::class, $factory->create($this->createStub(Collator::class)));
    }
}
