<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Collator;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator as IntlCollator;
use IntlException;
use Override;

use function assert;
use function is_int;

final class ConfigurableCollator implements Collator
{
    public function __construct(private readonly IntlCollator $collator, private readonly Configuration $config)
    {
    }

    /** @throws IntlSortException */
    #[Override]
    public function compare(mixed $value, mixed $comparativeValue): int
    {
        if ($this->isNullFirst($value, $comparativeValue)) {
            return -1;
        }

        if ($this->isNullLast($value, $comparativeValue)) {
            return 1;
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

    private function isNullFirst(mixed $value, mixed $comparativeValue): bool
    {
        $nullFirstArg1 = $value === null && $comparativeValue !== null && $this->config->isNullValueFirst();
        $nullLastArg2  = $value !== null && $comparativeValue === null && $this->config->isNullValueLast();

        return $nullFirstArg1 || $nullLastArg2;
    }

    private function isNullLast(mixed $value, mixed $comparativeValue): bool
    {
        $nullLastArg1  = $value === null && $comparativeValue !== null && $this->config->isNullValueLast();
        $nullFirstArg2 = $value !== null && $comparativeValue === null && $this->config->isNullValueFirst();

        return $nullLastArg1 || $nullFirstArg2;
    }
}
