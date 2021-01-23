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

    public static function invalidLocale(string $locale): self
    {
        return new self(sprintf('Could not create Collator instance because of invalid locale "%s".', $locale));
    }

    public static function doesNotImplementComparable(string $classname): self
    {
        return new self(sprintf('Class "%s" does not implement Comaprable interface.', $classname));
    }

    public static function classDoesNotExist(string $classname): self
    {
        return new self(sprintf('Class "%s" does not exist.', $classname));
    }
}
