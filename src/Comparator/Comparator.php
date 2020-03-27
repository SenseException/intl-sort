<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

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

    public function compare(string $value, string $comparativeValue): Result
    {
        return new SignedIntResult($this->collator->compare($value, $comparativeValue));
    }
}