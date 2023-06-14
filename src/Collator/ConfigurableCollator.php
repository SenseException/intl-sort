<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Collator;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator as IntlCollator;
use IntlException;

use function assert;
use function is_int;

final class ConfigurableCollator implements Collator
{
    public function __construct(private readonly IntlCollator $collator, private readonly Configuration $config)
    {
    }

    /** @throws IntlSortException */
    public function compare(mixed $value, mixed $comparativeValue): int
    {
        $nullFirstArg1 = $value === null && $comparativeValue !== null && $this->config->isNullValueFirst();
        $nullFirstArg2 = $value !== null && $comparativeValue === null && $this->config->isNullValueFirst();
        $nullLastArg1  = $value === null && $comparativeValue !== null && $this->config->isNullValueLast();
        $nullLastArg2  = $value !== null && $comparativeValue === null && $this->config->isNullValueLast();

        $nullableMatch = match (true) {
            $nullFirstArg1, $nullLastArg2 => -1,
            $nullLastArg1, $nullFirstArg2 => 1,
            default => null,
        };

        if ($nullableMatch !== null) {
            return $nullableMatch;
        }

        try {
            $compared = $this->collator->compare((string) $value, (string) $comparativeValue);

            assert(is_int($compared));

            if ($this->collator->getErrorCode() !== 0) {
                throw IntlSortException::errorOnSort($this->collator->getErrorMessage());
            }
        } catch (IntlException $e) {
            throw IntlSortException::errorOnSort($e->getMessage());
        }

        return $compared;
    }
}
