<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

use Budgegeria\IntlSort\Exception\IntlSortException;
use Collator;
use IntlException;

class ValueObject implements Comparable
{
    /** @var Collator */
    private $collator;

    /** @var string */
    private $methodOrPropertyName;

    /** @var bool */
    private $isProperty;

    public function __construct(Collator $collator, string $name, bool $isProperty)
    {
        $this->collator             = $collator;
        $this->methodOrPropertyName = $name;
        $this->isProperty           = $isProperty;
    }

    /**
     * {@inheritDoc}
     */
    public function compare($value, $comparativeValue): int
    {
        try {
            /** @var int $compared */
            $compared = $this->collator->compare(
                $this->callAccessor($value),
                $this->callAccessor($comparativeValue)
            );

            if ($this->collator->getErrorCode() !== 0) {
                throw IntlSortException::errorOnSort($this->collator->getErrorMessage());
            }
        } catch (IntlException $e) {
            throw IntlSortException::errorOnSort($e->getMessage());
        }

        return $compared;
    }

    private function callAccessor(object $valueObject): string
    {
        if ($this->isProperty) {
            return (string) $valueObject->{$this->methodOrPropertyName};
        }

        return (string) $valueObject->{$this->methodOrPropertyName}();
    }
}
