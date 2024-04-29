<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Comparator\Comparable;
use Override;

use function uasort;

final class Asc implements Sorter
{
    public function __construct(private readonly Comparable $comparable)
    {
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function sort(array $values): array
    {
        uasort(
            $values,
            fn (mixed $first, mixed $second): int => $this->comparable->compare($first, $second),
        );

        return $values;
    }
}
