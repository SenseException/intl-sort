<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

final class Desc implements Sorter
{
    /**
     * @var Sorter
     */
    private $sorter;

    public function __construct(Sorter $sorter)
    {
        $this->sorter = $sorter;
    }

    /**
     * {@inheritDoc}
     */
    public function sort(array $values) : array
    {
        $values = $this->sorter->sort($values);

        return array_reverse($values, true);
    }
}