<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests;

use Budgegeria\IntlSort\Builder;
use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\ComparatorFactory\Factory;
use Budgegeria\IntlSort\Sorter\Sorter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    private Builder $builder;

    protected function setUp(): void
    {
        $this->builder = Builder::create('fr_FR');
    }

    public function testGetSorter(): void
    {
        self::assertAsc($this->builder->getSorter());
    }

    public function testOrderByDesc(): void
    {
        self::assertDesc($this->builder->orderByDesc()->getSorter());
    }

    public function testOrderByAsc(): void
    {
        self::assertAsc($this->builder->orderByDesc()->orderByAsc()->getSorter());
    }

    public function testOrderByKeys(): void
    {
        self::assertKeyAsc($this->builder->orderByKeys()->getSorter());
    }

    public function testOrderByKeysDesc(): void
    {
        self::assertKeyDesc($this->builder->orderByKeys()->orderByDesc()->getSorter());
    }

    public function testOrderByValues(): void
    {
        self::assertAsc($this->builder->orderByKeys()->orderByValues()->getSorter());
    }

    public function testComparator(): void
    {
        self::assertSame(0, $this->builder->getComparator()->compare('a', 'a'));
    }

    public function testOmitKeysOnSortedValues(): void
    {
        $expected = [1, 2, 3];
        $result   = $this->builder->omitKeys()
            ->getSorter()
            ->sort([3, 1, 2]);

        self::assertSame($expected, $result);
    }

    public function testKeepKeysOnSortedValues(): void
    {
        $expected = [1 => 1, 2 => 2, 0 => 3];
        $result   = $this->builder->omitKeys()
            ->keepKeys()
            ->getSorter()
            ->sort([3, 1, 2]);

        self::assertSame($expected, $result);
    }

    public function testEnableNormalizationMode(): void
    {
        $expected = [0 => 'ạ̈', 1 => 'ạ̈'];
        $result   = $this->builder
            ->enableNormalizationMode()
            ->getSorter()
            ->sort(['ạ̈', 'ạ̈']);

        self::assertSame($expected, $result);
    }

    public function testDisableNormalizationMode(): void
    {
        $expected = [1 => 'ạ̈', 0 => 'ạ̈'];
        $result   = $this->builder
            ->enableNormalizationMode()
            ->disableNormalizationMode()
            ->getSorter()
            ->sort(['ạ̈', 'ạ̈']);

        self::assertSame($expected, $result);
    }

    public function testEnableCaseLevel(): void
    {
        $expected = [1 => 'b', 0 => 'B', 2 => 'c'];
        $result   = $this->builder
            ->enableCaseLevel()
            ->primaryStrength()
            ->getSorter()
            ->sort(['B', 'b', 'c']);

        self::assertSame($expected, $result);
    }

    /**
     * @param string[] $values
     */
    #[DataProvider('provideDisabledCaseLevelValues')]
    public function testDisableCaseLevel(array $values): void
    {
        $result = $this->builder
            ->enableCaseLevel()
            ->disableCaseLevel()
            ->primaryStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($values, $result);
    }

    /** @return iterable<int, array<int, array<int, string>>> */
    public static function provideDisabledCaseLevelValues(): iterable
    {
        yield [['b', 'B', 'c']];
        yield [['B', 'b', 'c']];
    }

    /**
     * @param string[] $values
     */
    #[DataProvider('providePrimaryStrengthValues')]
    public function testPrimaryStrength(array $values): void
    {
        $result = $this->builder
            ->primaryStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($values, $result);
    }

    /** @return iterable<int, array<int, array<int, string>>> */
    public static function providePrimaryStrengthValues(): iterable
    {
        yield [['côté', 'Côte', 'côte', 'd']];
        yield [['côte', 'côté', 'Côte', 'd']];
    }

    /**
     * @param string[] $values
     */
    #[DataProvider('provideSecondaryStrengthValues')]
    public function testSecondaryStrength(array $values): void
    {
        $result = $this->builder
            ->secondaryStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($values, $result);
    }

    /** @return iterable<int, array<int, array<int, string>>> */
    public static function provideSecondaryStrengthValues(): iterable
    {
        yield [['côte', 'Côte', 'côté', 'd']];
        yield [['Role', 'role', 'rôle']];
    }

    /**
     * @param string[] $values
     */
    #[DataProvider('provideTertiaryStrengthValues')]
    public function testTertiaryStrength(array $values): void
    {
        $result = $this->builder
            ->identicalStrength()
            ->tertiaryStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($values, $result);
    }

    /** @return iterable<int, array<int, array<int, string>>> */
    public static function provideTertiaryStrengthValues(): iterable
    {
        yield [['côte', 'Côte', 'côté']];
        yield [['role', 'Role', 'rôle']];
        yield [['𝑎', '𝐚']];
    }

    /**
     * @param string[] $values
     * @param string[] $expected
     */
    #[DataProvider('provideQuarternaryStrengthValues')]
    public function testQuarternaryStrength(array $values, array $expected): void
    {
        $result = $this->builder
            ->quaternaryStrength()
            ->shiftedAlternateHandling()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    /** @return iterable<int, array<int, array<int, string>>> */
    public static function provideQuarternaryStrengthValues(): iterable
    {
        yield [
            [
                'A',
                'USA',
                'U.S.A',
                'Z',
            ],
            [
                0 => 'A',
                2 => 'U.S.A',
                1 => 'USA',
                3 => 'Z',
            ],
        ];

        yield [
            [
                'ab',
                'aB',
                'a-b',
            ],
            [
                2 => 'a-b',
                0 => 'ab',
                1 => 'aB',
            ],
        ];
    }

    public function testIdenticalStrength(): void
    {
        $values   = ['𝑎', '𝐚'];
        $expected = [1 => '𝐚', 0 => '𝑎'];
        $result   = $this->builder
            ->identicalStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    public function testUpperCaseFirst(): void
    {
        $expected = [1 => 'B', 0 => 'b'];
        $result   = $this->builder
            ->upperCaseFirst()
            ->getSorter()
            ->sort(['b', 'B']);

        self::assertSame($expected, $result);
    }

    public function testLowerCaseFirst(): void
    {
        $expected = [1 => 'b', 0 => 'B'];
        $result   = $this->builder
            ->upperCaseFirst()
            ->lowerCaseFirst()
            ->getSorter()
            ->sort(['B', 'b']);

        self::assertSame($expected, $result);
    }

    public function testRemoveCaseFirst(): void
    {
        $expected = [1 => 'b', 0 => 'B'];
        $result   = $this->builder
            ->upperCaseFirst()
            ->removeCaseFirst()
            ->getSorter()
            ->sort(['B', 'b']);

        self::assertSame($expected, $result);
    }

    public function testNonIgnorableAlternateHandling(): void
    {
        $values   = ['USA', 'U.S.A'];
        $expected = [
            1 => 'U.S.A',
            0 => 'USA',
        ];
        $result   = $this->builder
            ->shiftedAlternateHandling()
            ->nonIgnorableAlternateHandling()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    public function testEnableNumericCollation(): void
    {
        $values   = ['100', '4'];
        $expected = [
            1 => '4',
            0 => '100',
        ];
        $result   = $this->builder
            ->enableNumericCollation()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    public function testDisableNumericCollation(): void
    {
        $values   = ['4', '100'];
        $expected = [
            1 => '100',
            0 => '4',
        ];
        $result   = $this->builder
            ->enableNumericCollation()
            ->disableNumericCollation()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    public function testEnableFrenchCollation(): void
    {
        $expected = [
            2 => 'cote',
            1 => 'côte',
            3 => 'coté',
            0 => 'côté',
        ];
        $result   = $this->builder
            ->enableFrenchCollation()
            ->getSorter()
            ->sort(['côté', 'côte', 'cote', 'coté']);

        self::assertSame($expected, $result);
    }

    public function testDisableFrenchCollation(): void
    {
        $expected = [
            2 => 'cote',
            3 => 'coté',
            1 => 'côte',
            0 => 'côté',
        ];
        $result   = $this->builder
            ->enableFrenchCollation()
            ->disableFrenchCollation()
            ->getSorter()
            ->sort(['côté', 'côte', 'cote', 'coté']);

        self::assertSame($expected, $result);
    }

    public function testUseCustomComparator(): void
    {
        $expected = [
            'c' => 'foo1',
            1 => 'foo2',
            'a' => 'foo4',
            'b' => 'foo3',
        ];

        $comparable = self::createStub(Comparable::class);
        $comparable->method('compare')
            ->willReturn(0);

        $comparatorFactory = $this->createMock(Factory::class);
        $comparatorFactory->expects(self::once())
            ->method('create')
            ->with(self::isInstanceOf(Collator::class))
            ->willReturn($comparable);

        $result = (new Builder('fr_FR', $comparatorFactory))
            ->getSorter()
            ->sort($expected);

        self::assertSame($expected, $result);
    }

    public function testGetDifferentSorterInstances(): void
    {
        self::assertNotSame($this->builder->getSorter(), $this->builder->getSorter());
    }

    public function testGetDifferentComparatorInstances(): void
    {
        self::assertNotSame($this->builder->getComparator(), $this->builder->getComparator());
    }

    public function testNullFirst(): void
    {
        $expected = [3 => null, 5 => null, 1 => '', 0 => 'a', 2 => 'b', 4 => 'c'];

        $builder = $this->builder->nullFirst();

        $comparator = $builder->getComparator();
        self::assertSame(
            $comparator->compare(null, ''),
            -1 * $comparator->compare('', null),
        );

        $result = $builder
            ->getSorter()
            ->sort([0 => 'a', 1 => '', 2 => 'b', 3 => null, 4 => 'c', 5 => null]);

        self::assertSame($expected, $result);
    }

    public function testNullLast(): void
    {
        $expected = [1 => '', 0 => 'a', 3 => 'b', 4 => 'c', 2 => null, 5 => null];

        $builder = $this->builder->nullLast();

        $comparator = $builder->getComparator();
        self::assertSame(
            $comparator->compare(null, ''),
            -1 * $comparator->compare('', null),
        );

        $result = $builder
            ->getSorter()
            ->sort([0 => 'a', 1 => '', 2 => null, 3 => 'b', 4 => 'c', 5 => null]);

        self::assertSame($expected, $result);
    }

    public function testRemoveNullableSort(): void
    {
        $expected = [1 => '', 2 => null, 5 => null, 0 => 'a', 3 => 'b', 4 => 'c'];
        $result   = $this->builder->nullLast()
            ->removeNullPosition()
            ->getSorter()
            ->sort([0 => 'a', 1 => '', 2 => null, 3 => 'b', 4 => 'c', 5 => null]);

        self::assertSame($expected, $result);
    }

    private static function assertAsc(Sorter $sorter): void
    {
        $expected = [
            3 => 1,
            2 => 'a',
            0 => 'b',
            1 => 'c',
        ];

        self::assertSame($expected, $sorter->sort(['b', 'c', 'a', 1]));
    }

    private static function assertDesc(Sorter $sorter): void
    {
        $expected = [
            1 => 'c',
            0 => 'b',
            2 => 'a',
            3 => 1,
        ];

        self::assertSame($expected, $sorter->sort(['b', 'c', 'a', 1]));
    }

    private static function assertKeyAsc(Sorter $sorter): void
    {
        $expected = [
            1 => 'foo',
            'a' => 'foo',
            'b' => 'foo',
            'c' => 'foo',
        ];

        self::assertSame($expected, $sorter->sort([
            'c' => 'foo',
            1 => 'foo',
            'a' => 'foo',
            'b' => 'foo',
        ]));
    }

    private static function assertKeyDesc(Sorter $sorter): void
    {
        $expected = [
            'c' => 'foo',
            'b' => 'foo',
            'a' => 'foo',
            1 => 'foo',
        ];

        self::assertSame($expected, $sorter->sort([
            'c' => 'foo',
            1 => 'foo',
            'a' => 'foo',
            'b' => 'foo',
        ]));
    }
}
