<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Collator\Collator as IntlSortCollator;
use Budgegeria\IntlSort\Comparator\Comparator;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Budgegeria\IntlSort\Tests\Collator;
use PHPUnit\Framework\TestCase;

/** @covers \Budgegeria\IntlSort\Comparator\Comparator */
class ComparatorTest extends TestCase
{
    use Collator;

    private Comparator $comparator;

    protected function setUp(): void
    {
        $this->comparator = new Comparator($this->createCollator());
    }

    public function testDelegateToCollator(): void
    {
        $collator = $this->createMock(IntlSortCollator::class);
        $collator->expects(self::once())
            ->method('compare')
            ->with('1', 'a')
            ->willReturn(-1);

        self::assertSame(-1, (new Comparator($collator))->compare(1, 'a'));
    }

    public function testIsSame(): void
    {
        self::assertSame(0, $this->comparator->compare('a', 'a'));
        self::assertSame(0, $this->comparator->compare(1, 1));
        self::assertSame(0, $this->comparator->compare(1, '1'));
    }

    public function testIsGreater(): void
    {
        self::assertSame(1, $this->comparator->compare('b', 'a'));
        self::assertSame(1, $this->comparator->compare(2, 1));
        self::assertSame(1, $this->comparator->compare('a', 1));
    }

    public function testIsLess(): void
    {
        self::assertSame(-1, $this->comparator->compare('a', 'b'));
        self::assertSame(-1, $this->comparator->compare(1, 2));
        self::assertSame(-1, $this->comparator->compare(1, 'a'));
    }

    public function testThrowsIntlException(): void
    {
        $collator = self::createStub(IntlSortCollator::class);
        $collator->method('compare')
            ->willThrowException(new IntlSortException('error'));

        $this->expectException(IntlSortException::class);
        (new Comparator($collator))->compare('a', 'b');
    }
}
