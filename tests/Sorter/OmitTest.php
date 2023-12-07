<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Sorter;

use Budgegeria\IntlSort\Comparator\Comparator;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Budgegeria\IntlSort\Sorter\Asc;
use Budgegeria\IntlSort\Sorter\Omit;
use Budgegeria\IntlSort\Sorter\Sorter;
use Budgegeria\IntlSort\Tests\Collator;
use PHPUnit\Framework\TestCase;

class OmitTest extends TestCase
{
    use Collator;

    public function testSort(): void
    {
        $comparator = $this->createMock(Sorter::class);
        $comparator->expects(self::once())
            ->method('sort')
            ->with([2, 1])
            ->willReturn([1 => 1, 0 => 2]);

        $sorter = new Omit($comparator);

        self::assertSame([1, 2], $sorter->sort([2, 1]));
    }

    public function testSortIntegration(): void
    {
        $sorter = new Omit(new Asc(new Comparator($this->createCollator())));

        self::assertSame([1, 'a', 'b', 'c'], $sorter->sort(['b', 'c', 'a', 1]));
    }

    public function testSortThrowsException(): void
    {
        $sorter = self::createStub(Sorter::class);
        $sorter->method('sort')
            ->willThrowException(IntlSortException::errorOnSort('error'));

        $sorter = new Omit($sorter);

        $this->expectException(IntlSortException::class);
        $sorter->sort([1, 2]);
    }
}
