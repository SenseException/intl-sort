<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Factory;

use Budgegeria\IntlSort\Sorter\Sorter;

interface SorterFactory
{
    public function create() : Sorter;
}