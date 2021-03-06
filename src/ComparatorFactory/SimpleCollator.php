<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\ComparatorFactory;

use Budgegeria\IntlSort\Comparator\CollatorConstructor;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator as IntlCollator;

use function class_exists;
use function class_implements;
use function in_array;

class SimpleCollator implements Factory
{
    /** @var class-string<CollatorConstructor> $classname */
    private $classname;

    /**
     * @psalm-param class-string<CollatorConstructor> $classname
     */
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

    public function create(IntlCollator $collator): Comparable
    {
        $classname = $this->classname;

        return new $classname($collator);
    }
}
