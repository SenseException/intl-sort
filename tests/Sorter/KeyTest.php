<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Sorter;

use Budgegeria\IntlSort\Collator;
use Budgegeria\IntlSort\Collator\ConfigurableCollator;
use Budgegeria\IntlSort\Collator\Configuration;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Comparator\Comparator;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Budgegeria\IntlSort\Sorter\Key;
use PHPUnit\Framework\TestCase;

class KeyTest extends TestCase
{
    public function testSort(): void
    {
        $comparator = $this->createMock(Comparable::class);
        $comparator->expects(self::once())
            ->method('compare')
            ->with(1, 2)
            ->willReturn(-1);

        $sorter = new Key($comparator);

        self::assertSame([1 => 'b', 2 => 'a'], $sorter->sort([1 => 'b', 2 => 'a']));
    }

    public function testSortIntegration(): void
    {
        $sortArray = [
            'c' => 'foo',
            1 => 'foo',
            'a' => 'foo',
            'b' => 'foo',
        ];
        $expected  = [
            1 => 'foo',
            'a' => 'foo',
            'b' => 'foo',
            'c' => 'foo',
        ];

        $sorter = new Key(new Comparator(new ConfigurableCollator(new Collator('en_US'), new Configuration())));

        self::assertSame($expected, $sorter->sort($sortArray));
    }

    public function testSortThrowsException(): void
    {
        $comparator = $this->createStub(Comparator::class);
        $comparator->method('compare')
            ->willThrowException(IntlSortException::errorOnSort('error'));

        $sorter = new Key($comparator);

        $this->expectException(IntlSortException::class);
        $sorter->sort([1, 2]);
    }
}
