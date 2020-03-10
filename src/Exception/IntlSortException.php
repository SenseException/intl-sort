<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Exception;

use Exception;

class IntlSortException extends Exception
{
    public static function errorOnSort() : self
    {
        return new self(sprintf('An error occurred during the sort-process: %s.', intl_get_error_message()));
    }
}