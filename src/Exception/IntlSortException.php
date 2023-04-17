<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Exception;

use Exception;

use function sprintf;

class IntlSortException extends Exception
{
    public static function errorOnSort(string $errorMessage): self
    {
        return new self(sprintf('An error occurred during the sort-process: %s.', $errorMessage));
    }

    /** @deprecated This method is deprecated and will be removed in 3.0 */
    public static function doesNotImplementComparable(string $classname): self
    {
        return new self(sprintf('Class "%s" does not implement Comparable interface.', $classname));
    }

    /** @deprecated This method is deprecated and will be removed in 3.0 */
    public static function classDoesNotExist(string $classname): self
    {
        return new self(sprintf('Class "%s" does not exist.', $classname));
    }
}
