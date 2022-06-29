<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Collator;

interface Collator
{
    public function compare(mixed $value, mixed $comparativeValue): int;
}
