<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Comparator\ValueObject as Comparator;
use Collator;

class ValueObject implements Factory
{
    /** @var string */
    private $methodOrPropertyName;

    /** @var bool */
    private $isProperty;

    public function __construct(string $name, bool $isProperty = false)
    {
        $this->methodOrPropertyName = $name;
        $this->isProperty           = $isProperty;
    }

    public function create(Collator $collator): Comparable
    {
        return new Comparator($collator, $this->methodOrPropertyName, $this->isProperty);
    }
}
