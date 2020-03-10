<?php

namespace Budgegeria\IntlSort\Tests\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Budgegeria\IntlSort\Sorter\Desc;
use Budgegeria\IntlSort\Sorter\Sorter;
use PHPUnit\Framework\TestCase;

class DescTest extends TestCase
{
    public function testSort() : void
    {
        $innerSorter = $this->createStub(Sorter::class);
        $innerSorter->method('sort')
            ->willReturn([3 => 1, 2 => 'a', 0 => 'b', 1 => 'c']);

        $sorter = new Desc($innerSorter);

        self::assertSame([1 => 'c', 0 => 'b', 2 => 'a', 3 => 1], $sorter->sort([]));
    }

    public function testSortThrowsException() : void
    {
        $innerSorter = $this->createStub(Sorter::class);
        $innerSorter->method('sort')
            ->willThrowException(new IntlSortException('test'));

        $sorter = new Desc($innerSorter);

        $this->expectException(IntlSortException::class);
        $sorter->sort([]);
    }
}
