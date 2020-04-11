<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests;

use Budgegeria\IntlSort\Sorter\Sorter;
use Budgegeria\IntlSort\Builder;
use Budgegeria\IntlSort\SorterFactory\Factory;
use Collator;
use Generator;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    /**
     * @var Builder
     */
    private $builder;

    protected function setUp(): void
    {
        $this->builder = new Builder('fr_FR');
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
        self::assertTrue($this->builder->getComparator()->compare('a', 'a')->isSame());
    }

    public function testEnableNormalizationMode(): void
    {
        $expected = [0 => 'ạ̈', 1 => 'ạ̈'];
        $result = $this->builder
            ->enableNormalizationMode()
            ->getSorter()
            ->sort(['ạ̈', 'ạ̈']);

        self::assertSame($expected, $result);
    }

    public function testDisableNormalizationMode(): void
    {
        $expected = [1 => 'ạ̈', 0 => 'ạ̈'];
        $result = $this->builder
            ->enableNormalizationMode()
            ->disableNormalizationMode()
            ->getSorter()
            ->sort(['ạ̈', 'ạ̈']);

        self::assertSame($expected, $result);
    }

    public function testEnableCaseLevel(): void
    {
        $expected = [1 => 'b', 0 => 'B', 2 => 'c'];
        $result = $this->builder
            ->enableCaseLevel()
            ->primaryStrength()
            ->getSorter()
            ->sort(['B', 'b', 'c']);

        self::assertSame($expected, $result);
    }

    /**
     * @dataProvider provideDisabledCaseLevelValues
     *
     * @param string[] $values
     */
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

    /**
     * @return Generator<array<int, array<int, string>>>
     */
    public function provideDisabledCaseLevelValues(): Generator
    {
        yield [['b', 'B', 'c']];
        yield [['B', 'b', 'c']];
    }

    /**
     * @dataProvider providePrimaryStrengthValues
     *
     * @param string[] $values
     */
    public function testPrimaryStrength(array $values): void
    {
        $result = $this->builder
            ->primaryStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($values, $result);
    }

    /**
     * @return Generator<array<int, array<int, string>>>
     */
    public function providePrimaryStrengthValues(): Generator
    {
        yield [['côté', 'Côte', 'côte', 'd']];
        yield [['côte', 'côté', 'Côte', 'd']];
    }

    /**
     * @dataProvider provideSecondaryStrengthValues
     *
     * @param string[] $values
     */
    public function testSecondaryStrength(array $values): void
    {
        $result = $this->builder
            ->secondaryStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($values, $result);
    }

    /**
     * @return Generator<array<int, array<int, string>>>
     */
    public function provideSecondaryStrengthValues(): Generator
    {
        yield [['côte', 'Côte', 'côté', 'd']];
        yield [['Role', 'role', 'rôle']];
    }

    /**
     * @dataProvider provideTertiaryStrengthValues
     *
     * @param string[] $values
     */
    public function testTertiaryStrength(array $values): void
    {
        $result = $this->builder
            ->identicalStrength()
            ->tertiaryStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($values, $result);
    }

    /**
     * @return Generator<array<int, array<int, string>>>
     */
    public function provideTertiaryStrengthValues(): Generator
    {
        yield [['côte', 'Côte', 'côté']];
        yield [['role', 'Role', 'rôle']];
        yield [['𝑎', '𝐚']];
    }

    /**
     * @dataProvider provideQuarternaryStrengthValues
     *
     * @param string[] $values
     * @param string[] $expected
     */
    public function testQuarternaryStrength(array $values, array $expected): void
    {
        $result = $this->builder
            ->quaternaryStrength()
            ->shiftedAlternateHandling()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    /**
     * @return Generator<array<int, array<int, string>>>
     */
    public function provideQuarternaryStrengthValues(): Generator
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
        $values = ['𝑎', '𝐚'];
        $expected = [1 => '𝐚', 0 => '𝑎'];
        $result = $this->builder
            ->identicalStrength()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    public function testUpperCaseFirst(): void
    {
        $expected = [1 => 'B', 0 => 'b'];
        $result = $this->builder
            ->upperCaseFirst()
            ->getSorter()
            ->sort(['b', 'B']);

        self::assertSame($expected, $result);
    }

    public function testLowerCaseFirst(): void
    {
        $expected = [1 => 'b', 0 => 'B'];
        $result = $this->builder
            ->upperCaseFirst()
            ->lowerCaseFirst()
            ->getSorter()
            ->sort(['B', 'b']);

        self::assertSame($expected, $result);
    }

    public function testRemoveCaseFirst(): void
    {
        $expected = [1 => 'b', 0 => 'B'];
        $result = $this->builder
            ->upperCaseFirst()
            ->removeCaseFirst()
            ->getSorter()
            ->sort(['B', 'b']);

        self::assertSame($expected, $result);
    }

    public function testShiftedAlternateHandling(): void
    {
        $values = ['USA', 'U.S.A'];
        $unexpected = [
            1 => 'U.S.A',
            0 => 'USA',
        ];
        $result = $this->builder
            ->shiftedAlternateHandling()
            ->getSorter()
            ->sort($values);

        self::assertSame($values, $result);
        self::assertNotSame($unexpected, $result);
    }

    public function testNonIgnorableAlternateHandling(): void
    {
        $values = ['USA', 'U.S.A'];
        $expected = [
            1 => 'U.S.A',
            0 => 'USA',
        ];
        $result = $this->builder
            ->shiftedAlternateHandling()
            ->nonIgnorableAlternateHandling()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    public function testEnableNumericCollation(): void
    {
        $values = ['100', '4'];
        $expected = [
            1 => '4',
            0 => '100',
        ];
        $result = $this->builder
            ->enableNumericCollation()
            ->getSorter()
            ->sort($values);

        self::assertSame($expected, $result);
    }

    public function testDisableNumericCollation(): void
    {
        $values = ['4', '100'];
        $expected = [
            1 => '100',
            0 => '4',
        ];
        $result = $this->builder
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
        $result = $this->builder
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
        $result = $this->builder
            ->enableFrenchCollation()
            ->disableFrenchCollation()
            ->getSorter()
            ->sort(['côté', 'côte', 'cote', 'coté']);

        self::assertSame($expected, $result);
    }

    public function testUseCustomSorter(): void
    {
        $expected = [
            'c' => 'foo',
            1 => 'foo',
            'a' => 'foo',
            'b' => 'foo',
        ];

        $sorter = $this->createStub(Sorter::class);
        $sorter->method('sort')
            ->willReturn($expected);

        $sorterFactory = $this->createMock(Factory::class);
        $sorterFactory->expects(self::once())
            ->method('createSorter')
            ->with(self::isInstanceOf(Collator::class))
            ->willReturn($sorter);

        $result = $this->builder
            ->orderByKeys()
            ->orderByCustomSorter($sorterFactory)
            ->getSorter()
            ->sort($expected);

        self::assertSame($expected, $result);
    }

    public function testUnsetCustomSorter(): void
    {
        $expected = [
            'c' => 'foo',
            1 => 'foo',
            'a' => 'foo',
            'b' => 'foo',
        ];

        $sorterFactory = $this->createMock(Factory::class);
        $sorterFactory->expects(self::never())
            ->method('createSorter');

        $result = $this->builder
            ->orderByAsc()
            ->orderByCustomSorter($sorterFactory)
            ->unsetOrderByCustomSorter()
            ->getSorter()
            ->sort($expected);

        self::assertSame($expected, $result);
    }

    private static function assertAsc(Sorter $sorter): void
    {
        $expected = [
            3 => 1,
            2 => 'a',
            0 => 'b',
            1 => 'c'
        ];

        self::assertSame($expected, $sorter->sort(['b', 'c', 'a', 1]));
    }

    private static function assertDesc(Sorter $sorter): void
    {
        $expected = [
            1 => 'c',
            0 => 'b',
            2 => 'a',
            3 => 1
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
