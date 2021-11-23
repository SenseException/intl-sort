<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Comparator\Comparable;

use function uksort;

final class Key implements Sorter
{
    public function __construct(private Comparable $comparable)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function sort(array $values): array
    {
        $comparable = $this->comparable;
        uksort(
            $values,
            static function (mixed $first, mixed $second) use ($comparable): int {
                return $comparable->compare($first, $second);
            }
        );

        return $values;
    }
}
