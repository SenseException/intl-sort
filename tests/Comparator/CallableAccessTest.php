<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\CallableAccess;
use PHPUnit\Framework\TestCase;

use function assert;
use function is_array;

/** @covers \Budgegeria\IntlSort\Comparator\CallableAccess */
class CallableAccessTest extends TestCase
{
    public function testCollatorWithFunction(): void
    {
        $func     = static function (mixed $value): string {
            assert(is_array($value));

            return (string) $value['foo'];
        };
        $collator = self::createMock(Collator::class);
        $collator->expects(self::once())
            ->method('compare')
            ->with('1', '2')
            ->willReturn(-1);

        $comparator = new CallableAccess($collator, $func);

        self::assertSame(-1, $comparator->compare(['foo' => '1'], ['foo' => '2']));
    }

    public function testCollatorWithClass(): void
    {
        $func     = new class {
            public function __invoke(mixed $value): string
            {
                assert(is_array($value));

                return (string) $value['foo'];
            }
        };
        $collator = self::createMock(Collator::class);
        $collator->expects(self::once())
            ->method('compare')
            ->with('1', '2')
            ->willReturn(-1);

        $comparator = new CallableAccess($collator, $func);

        self::assertSame(-1, $comparator->compare(['foo' => '1'], ['foo' => '2']));
    }
}
