<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\ComparatorFactory;

use ArrayObject;
use Budgegeria\IntlSort\ComparatorFactory\SimpleCollator;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Budgegeria\IntlSort\Tests\ComparatorFactory\Fixtures\Foo;
use Collator as IntlCollator;
use PHPUnit\Framework\TestCase;

class SimpleCollatorTest extends TestCase
{
    public function testCreate(): void
    {
        self::assertInstanceOf(Foo::class, (new SimpleCollator(Foo::class))->create(new IntlCollator('de_DE')));
    }

    public function testClassIsNotAComparable(): void
    {
        $this->expectException(IntlSortException::class);
        /**
         * @psalm-suppress InvalidArgument
         * @phpstan-ignore-next-line
         */
        new SimpleCollator(ArrayObject::class);
    }

    public function testClassDoesNotExist(): void
    {
        $this->expectException(IntlSortException::class);
        /**
         * @psalm-suppress ArgumentTypeCoercion
         * @psalm-suppress UndefinedClass
         * @phpstan-ignore-next-line
         */
        new SimpleCollator('NotExistent');
    }
}
