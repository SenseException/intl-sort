<?php

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Comparator\Comparator;
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
        self::assertTrue($this->comparator->compare('a', 'a')->isSame());
        self::assertFalse($this->comparator->compare('a', 'b')->isSame());
        self::assertFalse($this->comparator->compare('b', 'a')->isSame());
    }

    public function testIsGreater(): void
    {
        self::assertFalse($this->comparator->compare('a', 'a')->isGreater());
        self::assertFalse($this->comparator->compare('a', 'b')->isGreater());
        self::assertTrue($this->comparator->compare('b', 'a')->isGreater());
    }

    public function testIsLess(): void
    {
        self::assertFalse($this->comparator->compare('a', 'a')->isLess());
        self::assertTrue($this->comparator->compare('a', 'b')->isLess());
        self::assertFalse($this->comparator->compare('b', 'a')->isLess());
    }
}
