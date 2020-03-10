<?php

declare(strict_types=1);


namespace Budgegeria\IntlSort\Tests\Exception;


use Budgegeria\IntlSort\Exception\IntlSortException;
use PHPUnit\Framework\TestCase;

class IntlSortExceptionTest extends TestCase
{
    public function testErrorOnSort() : void
    {
        $e = IntlSortException::errorOnSort();

        self::assertSame('An error occurred during the sort-process: U_ZERO_ERROR.', $e->getMessage());
    }
}
