<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Collator;

use Budgegeria\IntlSort\Collator\ConfigurableCollator;
use Budgegeria\IntlSort\Collator\Configuration;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator;
use IntlException;
use PHPUnit\Framework\TestCase;

/** @todo Create functional tests of exception cases instead unit tests. */
class ConfigurableCollatorTest extends TestCase
{
    public function testExceptionOnIntlException(): void
    {
        $collator = self::createStub(Collator::class);
        $collator->method('compare')->willThrowException(new IntlException('error'));
        $config = new Configuration();

        $configurableCollator = new ConfigurableCollator($collator, $config);

        $this->expectException(IntlSortException::class);
        $configurableCollator->compare('', '');
    }

    public function testExceptionOnIntlError(): void
    {
        $collator = self::createStub(Collator::class);
        $collator->method('compare')->willReturn(1);
        $collator->method('getErrorCode')->willReturn(42);
        $collator->method('getErrorMessage')->willReturn('Error');
        $config = new Configuration();

        $configurableCollator = new ConfigurableCollator($collator, $config);

        $this->expectException(IntlSortException::class);
        $configurableCollator->compare('', '');
    }
}
