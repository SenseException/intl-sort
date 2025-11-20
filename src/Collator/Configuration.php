<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Collator;

/** @internal */
class Configuration
{
    public const int NULL_VALUES_FIRST = 1;
    public const int NULL_VALUES_LAST  = 2;

    /** @phpstan-var self::NULL_VALUES_*|null */
    private int|null $nullableSort = null;

    /** @phpstan-param self::NULL_VALUES_*|null $value */
    public function setNullableSort(int|null $value): void
    {
        $this->nullableSort = $value;
    }

    public function isNullValueFirst(): bool
    {
        return $this->nullableSort === self::NULL_VALUES_FIRST;
    }

    public function isNullValueLast(): bool
    {
        return $this->nullableSort === self::NULL_VALUES_LAST;
    }
}
