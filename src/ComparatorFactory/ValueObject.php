<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Comparator\ValueObject as Comparator;

/** @deprecated This class is deprecated and will be removed in 3.0. Please use Budgegeria\IntlSort\ComparatorFactory\CallableAccess instead */
class ValueObject implements Factory
{
    public function __construct(private string $methodOrPropertyName, private bool $isProperty)
    {
    }

    public function create(Collator $collator): Comparable
    {
        return new Comparator($collator, $this->methodOrPropertyName, $this->isProperty);
    }

    public static function createForMethodCall(string $methodName): self
    {
        return new self($methodName, false);
    }

    public static function createForPropertyCall(string $propertyName): self
    {
        return new self($propertyName, true);
    }
}
