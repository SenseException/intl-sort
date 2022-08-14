<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Collator;

class Configuration
{
    public const NULL_VALUES_FIRST = 1;
    public const NULL_VALUES_LAST  = 2;

    /** @phpstan-var self::NULL_VALUES_*|null */
    private ?int $nullableSort = null;

    /**
     * @phpstan-param self::NULL_VALUES_*|null $value
     */
    public function setNullableSort(?int $value): void
    {
        $this->nullableSort = $value;
    }

    /**
     * @phpstan-return self::NULL_VALUES_*|null
     */
    public function getNullableSort(): ?int
    {
        return $this->nullableSort;
    }
}
