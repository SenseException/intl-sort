<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Collator;
use Budgegeria\IntlSort\Comparator\ValueObject;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Generator;
use IntlException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Budgegeria\IntlSort\Comparator\ValueObject
 */
abstract class ValueObjectTest extends TestCase
{
    private ValueObject $comparator;

    protected function setUp(): void
    {
        $this->comparator = $this->createComparator(new Collator('en_US'));
    }

    public function testDelegateToCollator(): void
    {
        $collator = $this->createMock(Collator::class);
        $collator->expects(self::once())
            ->method('compare')
            ->with('1', 'a')
            ->willReturn(-1);
        $collator->expects(self::once())
            ->method('getErrorCode')
            ->willReturn(0);

        self::assertSame(-1, $this->createComparator($collator)->compare($this->createObject(1), $this->createObject('a')));
    }

    /**
     * @dataProvider provideObjectsToCompare
     */
    public function testCompare(object $object, object $comparativeObject, int $expected): void
    {
        self::assertSame($expected, $this->comparator->compare($object, $comparativeObject));
    }

    /**
     * @return Generator<array<object|int>>
     */
    public function provideObjectsToCompare(): Generator
    {
        yield 'isSameWithLetters' => [$this->createObject('a'), $this->createObject('a'), 0];
        yield 'isSameWithNumbers' => [$this->createObject(1), $this->createObject(1), 0];
        yield 'isSameMixedTypes' => [$this->createObject(1), $this->createObject('1'), 0];

        yield 'isGreaterWithLetters' => [$this->createObject('b'), $this->createObject('a'), 1];
        yield 'isGreaterWithNumbers' => [$this->createObject(2), $this->createObject(1), 1];
        yield 'isGreaterMixedTypes' => [$this->createObject('a'), $this->createObject(1), 1];

        yield 'isLessWithLetters' => [$this->createObject('a'), $this->createObject('b'), -1];
        yield 'isLessWithNumbers' => [$this->createObject(1), $this->createObject(2), -1];
        yield 'isLessMixedTypes' => [$this->createObject(1), $this->createObject('a'), -1];
    }

    public function testInvokesError(): void
    {
        $collator = $this->createStub(Collator::class);
        $collator->method('getErrorCode')
            ->willReturn(42);
        $collator->method('getErrorMessage')
            ->willReturn('error');

        $this->expectException(IntlSortException::class);
        $this->createComparator($collator)->compare($this->createObject('a'), $this->createObject('b'));
    }

    public function testThrowsIntlException(): void
    {
        $collator = $this->createStub(Collator::class);
        $collator->method('compare')
            ->willThrowException(new IntlException('error'));

        $this->expectException(IntlSortException::class);
        $this->createComparator($collator)->compare($this->createObject('a'), $this->createObject('b'));
    }

    abstract protected function createObject(int|string $value): object;

    abstract protected function createComparator(Collator $collator): ValueObject;
}
