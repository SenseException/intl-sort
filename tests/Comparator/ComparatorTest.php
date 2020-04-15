<?php

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Comparator\Comparator;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Budgegeria\IntlSort\Comparator\Comparator
 */
class ComparatorTest extends TestCase
{
    /**
     * @var Comparator
     */
    private $comparator;

    protected function setUp(): void
    {
        $this->comparator = new Comparator(new Collator('en_US'));
    }

    public function testIsSame(): void
    {
        self::assertSame(0, $this->comparator->compare('a', 'a'));
    }

    public function testIsGreater(): void
    {
        self::assertSame(1, $this->comparator->compare('b', 'a'));
    }

    public function testIsLess(): void
    {
        self::assertSame(-1, $this->comparator->compare('a', 'b'));
    }

    public function testInvokesError(): void
    {
        $collator = $this->createStub(Collator::class);
        $collator->method('getErrorCode')
            ->willReturn(42);
        $collator->method('getErrorMessage')
            ->willReturn('error');

        $this->expectException(IntlSortException::class);
        (new Comparator($collator))->compare('a', 'b');
    }
}
