<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Comparator\Comparable;

use function uasort;

final class Asc implements Sorter
{
    public function __construct(private readonly Comparable $comparable)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function sort(array $values): array
    {
        $comparable = $this->comparable;
        uasort(
            $values,
            static fn (mixed $first, mixed $second): int => $comparable->compare($first, $second)
        );

        return $values;
    }
}
