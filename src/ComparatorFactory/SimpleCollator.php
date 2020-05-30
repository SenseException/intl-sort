<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Comparator\CollatorConstructor;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator as IntlCollator;

class SimpleCollator implements Factory
{
    /**
     * @var class-string<\Budgegeria\IntlSort\Comparator\CollatorConstructor> $classname
     */
    private $classname;

    /**
     * @psalm-param class-string<\Budgegeria\IntlSort\Comparator\CollatorConstructor> $classname
     */
    public function __construct(string $classname)
    {
        if (! class_exists($classname)) {
            throw IntlSortException::classDoesNotExist($classname);
        }

        if (! in_array(CollatorConstructor::class, class_implements($classname), true)) {
            throw IntlSortException::doesNotImplementComparable($classname);
        }

        $this->classname = $classname;
    }

    public function create(IntlCollator $collator): Comparable
    {
        $classname = $this->classname;

        return new $classname($collator);
    }
}