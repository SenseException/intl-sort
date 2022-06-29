<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Collator;

use Collator as IntlCollator;

use function assert;
use function is_int;

class ConfigurableCollator implements Collator
{
    public function __construct(private IntlCollator $collator, private Configuration $config)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        if (($comparativeValue === null || $value === null) && $this->config->getNullableSort() === Configuration::NULL_VALUES_LAST) {
            return $comparativeValue <=> $value;
        }

        if (($comparativeValue === null || $value === null) && $this->config->getNullableSort() === Configuration::NULL_VALUES_FIRST) {
            return Configuration::NULL_VALUES_FIRST;
        }

        $result = $this->collator->compare((string) $value, (string) $comparativeValue);

        assert(is_int($result));

        return $result;
    }
}
