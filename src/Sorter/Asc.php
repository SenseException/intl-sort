<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Comparator\Comparable;
use function uasort;

final class Asc implements Sorter
{
    /**
     * @var Comparable
     */
    private $comparable;

    public function __construct(Comparable $comparable)
    {
        $this->comparable = $comparable;
    }

    /**
     * {@inheritDoc}
     */
    public function sort(array $values): array
    {
        $comparable = $this->comparable;
        uasort(
            $values,
            /**
             * @param mixed $first
             * @param mixed $second
             */
            static function ($first, $second) use ($comparable): int {
                return $comparable->compare($first, $second);
            }
        );

        return $values;
    }
}