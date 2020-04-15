<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator;

class Comparator implements Comparable
{
    /**
     * @var Collator
     */
    private $collator;

    public function __construct(Collator $collator)
    {
        $this->collator = $collator;
    }

    /**
     * {@inheritDoc}
     */
    public function compare($value, $comparativeValue): int
    {
        $compared = $this->collator->compare((string) $value, (string) $comparativeValue);

        if ($this->collator->getErrorCode() !== 0) {
            throw IntlSortException::errorOnSort($this->collator->getErrorMessage());
        }

        return $compared;
    }
}