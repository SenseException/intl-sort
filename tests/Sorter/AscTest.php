<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Budgegeria\IntlSort\Sorter\Asc;
use Collator;
use PHPUnit\Framework\TestCase;

class AscTest extends TestCase
{
    public function testSort() : void
    {
        $sorter = new Asc(new Collator('en_US'), Collator::SORT_STRING);

        self::assertSame([3 => 1, 2 => 'a', 0 => 'b', 1 => 'c'], $sorter->sort(['b', 'c', 'a', 1]));
    }

    public function testSortThrowsException() : void
    {
        $collator = $this->createStub(Collator::class);
        $collator->method('asort')
            ->willReturn(false);

        $sorter = new Asc($collator, Collator::SORT_STRING);

        $this->expectException(IntlSortException::class);
        $sorter->sort(['b', 'c', 'a']);
    }
}
