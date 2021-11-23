<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use function array_reverse;

final class Desc implements Sorter
{
    public function __construct(private Sorter $sorter)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function sort(array $values): array
    {
        $values = $this->sorter->sort($values);

        return array_reverse($values, true);
    }
}
