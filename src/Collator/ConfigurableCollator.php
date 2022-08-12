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
    public function __construct(private IntlCollator $collator, private Configuration $config)
    {
    }

    /**
     * @throws IntlSortException
     */
    public function compare(mixed $value, mixed $comparativeValue): int
    {
        if (($comparativeValue === null || $value === null) && $this->config->getNullableSort() === Configuration::NULL_VALUES_LAST) {
            return $comparativeValue <=> $value;
        }

        if (($comparativeValue === null || $value === null) && $this->config->getNullableSort() === Configuration::NULL_VALUES_FIRST) {
            return Configuration::NULL_VALUES_FIRST;
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
