<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Sorter;

use Override;

use function array_values;

final class Omit implements Sorter
{
    public function __construct(private readonly Sorter $sorter)
    {
    }

    /** @inheritdoc */
    #[Override]
    public function sort(array $values): array
    {
        $values = $this->sorter->sort($values);

        return array_values($values);
    }
}
