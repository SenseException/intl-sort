<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Collator\Collator;
use Budgegeria\IntlSort\Comparator\CollatorConstructor;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Exception\IntlSortException;

use function class_exists;
use function class_implements;
use function in_array;

/** @deprecated This class is deprecated and will be removed in 3.0. Please use Budgegeria\IntlSort\Comparator\CallableAccess instead */
class SimpleCollator implements Factory
{
    /** @var class-string<CollatorConstructor> $classname */
    private $classname;

    /** @psalm-param class-string<CollatorConstructor> $classname */
    public function __construct(string $classname)
    {
        if (! class_exists($classname)) {
            throw IntlSortException::classDoesNotExist($classname);
        }

        /** @var array<string> $interfaces */
        $interfaces = class_implements($classname);

        if (! in_array(CollatorConstructor::class, $interfaces, true)) {
            throw IntlSortException::doesNotImplementComparable($classname);
        }

        $this->classname = $classname;
    }

    public function create(Collator $collator): Comparable
    {
        return new $this->classname($collator);
    }
}
