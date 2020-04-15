<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Sorter;

use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Comparator\Comparator;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Budgegeria\IntlSort\Sorter\Asc;
use Collator;
use PHPUnit\Framework\TestCase;

class AscTest extends TestCase
{
    public function testSort(): void
    {
        $comparator = $this->createMock(Comparable::class);
        $comparator->expects(self::once())
            ->method('compare')
            ->with(1, 2)
            ->willReturn(-1);

        $sorter = new Asc($comparator);

        self::assertSame([1, 2], $sorter->sort([1, 2]));
    }

    public function testSortIntegration(): void
    {
        $sorter = new Asc(new Comparator(new Collator('en_US')));

        self::assertSame([3 => 1, 2 => 'a', 0 => 'b', 1 => 'c'], $sorter->sort(['b', 'c', 'a', 1]));
    }

    public function testSortThrowsException(): void
    {
        $comparator = $this->createStub(Comparator::class);
        $comparator->method('compare')
            ->willThrowException(IntlSortException::errorOnSort('error'));

        $sorter = new Asc($comparator);

        $this->expectException(IntlSortException::class);
        $sorter->sort([1, 2]);
    }
}
