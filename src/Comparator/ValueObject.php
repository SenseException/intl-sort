<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator;
use IntlException;

use function assert;
use function is_int;

class ValueObject implements Comparable
{
    public function __construct(private Collator $collator, private string $methodOrPropertyName, private bool $isProperty)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        try {
            $compared = $this->collator->compare(
                $this->callAccessor($value),
                $this->callAccessor($comparativeValue)
            );

            assert(is_int($compared));

            if ($this->collator->getErrorCode() !== 0) {
                throw IntlSortException::errorOnSort($this->collator->getErrorMessage());
            }
        } catch (IntlException $e) {
            throw IntlSortException::errorOnSort($e->getMessage());
        }

        return $compared;
    }

    private function callAccessor(object $valueObject): mixed
    {
        if ($this->isProperty) {
            return $valueObject->{$this->methodOrPropertyName};
        }

        return $valueObject->{$this->methodOrPropertyName}();
    }
}
