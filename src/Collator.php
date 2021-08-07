<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort;

use Collator as IntlCollector;

use function assert;
use function is_int;

class Collator extends IntlCollector
{
    /**
     * @param mixed $value
     * @param mixed $comparativeValue
     */
    public function compare($value, $comparativeValue): int
    {
        $result = parent::compare((string) $value, (string) $comparativeValue);

        assert(is_int($result));

        return $result;
    }
}
