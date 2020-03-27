<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests\Comparator;

use Budgegeria\IntlSort\Comparator\SignedIntResult;
use PHPUnit\Framework\TestCase;

class SignedIntResultTest extends TestCase
{
    public function testIsSame(): void
    {
        $result = new SignedIntResult(0);

        self::assertTrue($result->isSame());
        self::assertFalse($result->isGreater());
        self::assertFalse($result->isLess());
    }

    public function testIsGreater(): void
    {
        $result = new SignedIntResult(1);

        self::assertFalse($result->isSame());
        self::assertFalse($result->isLess());
        self::assertTrue($result->isGreater());
    }

    public function testIsLess(): void
    {
        $result = new SignedIntResult(-1);

        self::assertFalse($result->isSame());
        self::assertTrue($result->isLess());
        self::assertFalse($result->isGreater());
    }
}