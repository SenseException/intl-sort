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
}
