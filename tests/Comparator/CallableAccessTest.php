<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\CallableAccess;
use PHPUnit\Framework\TestCase;

/** @covers \Budgegeria\IntlSort\Comparator\CallableAccess */
class CallableAccessTest extends TestCase
{
    public function testDelegateToCollator(): void
    {
        $func     = static fn (array $value): string => (string) $value['foo'];
        $collator = self::createMock(Collator::class);
        $collator->expects(self::once())
            ->method('compare')
            ->with('1', '2')
            ->willReturn(-1);

        $comparator = new CallableAccess($collator, $func);

        self::assertSame(-1, $comparator->compare(['foo' => '1'], ['foo' => '2']));
    }
}
