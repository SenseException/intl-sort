<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator;
use function intl_get_error_message;
use function uksort;

final class Key implements Sorter
{
    /**
     * @var Collator
     */
    private $collator;

    public function __construct(Collator $collator)
    {
        $this->collator = $collator;
    }

    /**
     * {@inheritDoc}
     */
    public function sort(array $values) : array
    {
        $collator = $this->collator;
        uksort(
            $values,
            static function ($first, $second) use ($collator) : int {
                /** @var int|false $result */
                $result = $collator->compare((string) $first, (string) $second);
                if (false === $result) {
                    throw IntlSortException::errorOnSort(intl_get_error_message());
                }

                return $result;
            }
        );

        return $values;
    }
}