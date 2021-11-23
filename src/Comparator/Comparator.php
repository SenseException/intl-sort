<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator;
use IntlException;

class Comparator implements Comparable
{
    public function __construct(private Collator $collator)
    {
    }

    public function compare(mixed $value, mixed $comparativeValue): int
    {
        try {
            /** @var int $compared */
            $compared = $this->collator->compare($value, $comparativeValue);

            if ($this->collator->getErrorCode() !== 0) {
                throw IntlSortException::errorOnSort($this->collator->getErrorMessage());
            }
        } catch (IntlException $e) {
            throw IntlSortException::errorOnSort($e->getMessage());
        }

        return $compared;
    }
}
