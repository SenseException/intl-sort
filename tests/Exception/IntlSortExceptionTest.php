<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Exception;

use Budgegeria\IntlSort\Exception\IntlSortException;
use PHPUnit\Framework\TestCase;

class IntlSortExceptionTest extends TestCase
{
    public function testErrorOnSort(): void
    {
        $e = IntlSortException::errorOnSort('because reasons');

        self::assertSame('An error occurred during the sort-process: because reasons.', $e->getMessage());
    }
}
