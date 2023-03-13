<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Collator\Collator;

/** @deprecated This class is deprecated and will be removed in 3.0. Please use Budgegeria\IntlSort\Comparator\CallableAccess instead */
class ValueObject implements Comparable
{
    public function __construct(private Collator $collator, private string $methodOrPropertyName, private bool $isProperty)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        return $this->collator->compare(
            $this->callAccessor((object) $value),
            $this->callAccessor((object) $comparativeValue),
        );
    }

    private function callAccessor(object $valueObject): mixed
    {
        if ($this->isProperty) {
            return $valueObject->{$this->methodOrPropertyName};
        }

        return $valueObject->{$this->methodOrPropertyName}();
    }
}
