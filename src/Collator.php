<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort;

use Collator as IntlCollector;

use function assert;
use function is_int;

class Collator extends IntlCollector
{
    public const NULL_VALUES_FIRST = 1;
    public const NULL_VALUES_LAST  = 2;

    private ?int $nullableSort = null;

    public function setNullableSort(?int $value): void
    {
        $this->nullableSort = $value;
    }

    /**
     * @param mixed $value
     * @param mixed $comparativeValue
     */
    public function compare($value, $comparativeValue): int
    {
        if ($this->nullableSort === self::NULL_VALUES_LAST && ($comparativeValue === null || $value === null)) {
            return $comparativeValue <=> $value;
        }

        if ($this->nullableSort === self::NULL_VALUES_FIRST && ($comparativeValue === null || $value === null)) {
            return self::NULL_VALUES_FIRST;
        }

        $result = parent::compare((string) $value, (string) $comparativeValue);

        assert(is_int($result));

        return $result;
    }
}
