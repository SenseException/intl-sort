<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator;
use function intl_get_error_message;

final class Asc implements Sorter
{
    /**
     * @var Collator
     */
    private $collator;

    /**
     * @var int A Collator::SORT_* sort flag
     */
    private $sortType;

    public function __construct(Collator $collator, int $sortType)
    {
        $this->collator = $collator;
        $this->sortType = $sortType;
    }

    /**
     * {@inheritDoc}
     */
    public function sort(array $values): array
    {
        if (! $this->collator->asort($values, $this->sortType)) {
            throw IntlSortException::errorOnSort(intl_get_error_message());
        }

        return $values;
    }
}