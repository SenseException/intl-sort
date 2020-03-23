<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Budgegeria\IntlSort\Sorter\Key;
use Collator;
use Generator;
use PHPUnit\Framework\TestCase;

class KeyTest extends TestCase
{
    /**
     * @dataProvider provideSortedArrays
     *
     * @param array<int|string, string> $sortArray
     * @param array<int|string, string> $expected
     */
    public function testSort($sortArray, $expected): void
    {
        $sorter = new Key(new Collator('en_US'));

        self::assertSame($expected, $sorter->sort($sortArray));
    }

    public function testSortThrowsException(): void
    {
        $collator = $this->createStub(Collator::class);
        $collator->method('compare')
            ->willReturn(false);

        $sorter = new Key($collator);

        $this->expectException(IntlSortException::class);
        $sorter->sort(['b', 'c', 'a']);
    }

    /**
     * @return Generator<mixed>
     */
    public function provideSortedArrays(): Generator
    {
        yield 'mixed keys' => [
            [
                'c' => 'foo',
                1 => 'foo',
                'a' => 'foo',
                'b' => 'foo',
            ],
            [
                1 => 'foo',
                'a' => 'foo',
                'b' => 'foo',
                'c' => 'foo',
            ],
        ];
        yield 'numeric keys' => [
            [
                4 => 'foo',
                1 => 'foo',
                3 => 'foo',
                2 => 'foo',
            ],
            [
                1 => 'foo',
                2 => 'foo',
                3 => 'foo',
                4 => 'foo',
            ],
        ];
    }
}
