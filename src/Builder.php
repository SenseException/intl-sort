<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort;

use Budgegeria\IntlSort\Collator\ConfigurableCollator;
use Budgegeria\IntlSort\Collator\Configuration;
use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\ComparatorFactory\Factory;
use Budgegeria\IntlSort\ComparatorFactory\Standard;
use Budgegeria\IntlSort\Sorter\Asc;
use Budgegeria\IntlSort\Sorter\Desc;
use Budgegeria\IntlSort\Sorter\Key;
use Budgegeria\IntlSort\Sorter\Sorter;
use Collator;

class Builder
{
    private Collator $collator;

    private bool $isAsc = true;

    private bool $isKeySort = false;

    private Factory $comparatorFactory;

    private Configuration $configuration;

    public function __construct(string $locale, Factory|null $comparatorFactory = null)
    {
        $this->collator          = new Collator($locale);
        $this->configuration     = new Configuration();
        $this->comparatorFactory = $comparatorFactory ?? new Standard();
    }

    public static function create(string $locale): self
    {
        return new self($locale, new Standard());
    }

    public function enableFrenchCollation(): self
    {
        $this->collator->setAttribute(Collator::FRENCH_COLLATION, Collator::ON);

        return $this;
    }

    public function disableFrenchCollation(): self
    {
        $this->collator->setAttribute(Collator::FRENCH_COLLATION, Collator::OFF);

        return $this;
    }

    public function lowerCaseFirst(): self
    {
        $this->collator->setAttribute(Collator::CASE_FIRST, Collator::LOWER_FIRST);

        return $this;
    }

    public function upperCaseFirst(): self
    {
        $this->collator->setAttribute(Collator::CASE_FIRST, Collator::UPPER_FIRST);

        return $this;
    }

    public function removeCaseFirst(): self
    {
        $this->collator->setAttribute(Collator::CASE_FIRST, Collator::OFF);

        return $this;
    }

    public function enableNormalizationMode(): self
    {
        $this->collator->setAttribute(Collator::NORMALIZATION_MODE, Collator::ON);

        return $this;
    }

    public function disableNormalizationMode(): self
    {
        $this->collator->setAttribute(Collator::NORMALIZATION_MODE, Collator::OFF);

        return $this;
    }

    public function enableNumericCollation(): self
    {
        $this->collator->setAttribute(Collator::NUMERIC_COLLATION, Collator::ON);

        return $this;
    }

    public function disableNumericCollation(): self
    {
        $this->collator->setAttribute(Collator::NUMERIC_COLLATION, Collator::OFF);

        return $this;
    }

    public function enableCaseLevel(): self
    {
        $this->collator->setAttribute(Collator::CASE_LEVEL, Collator::ON);

        return $this;
    }

    public function disableCaseLevel(): self
    {
        $this->collator->setAttribute(Collator::CASE_LEVEL, Collator::OFF);

        return $this;
    }

    public function nonIgnorableAlternateHandling(): self
    {
        $this->collator->setAttribute(Collator::ALTERNATE_HANDLING, Collator::NON_IGNORABLE);

        return $this;
    }

    public function shiftedAlternateHandling(): self
    {
        $this->collator->setAttribute(Collator::ALTERNATE_HANDLING, Collator::SHIFTED);

        return $this;
    }

    /**
     * Ignore accents and case
     */
    public function primaryStrength(): self
    {
        $this->collator->setStrength(Collator::PRIMARY);

        return $this;
    }

    /**
     * Ignore case, consider accents
     */
    public function secondaryStrength(): self
    {
        $this->collator->setStrength(Collator::SECONDARY);

        return $this;
    }

    /**
     * Consider accents and case
     */
    public function tertiaryStrength(): self
    {
        $this->collator->setStrength(Collator::TERTIARY);

        return $this;
    }

    /**
     * Like tertiary, but also considers whitespace, punctuation, and symbols differently when
     * used with {@see shiftedAlternateHandling()}
     */
    public function quaternaryStrength(): self
    {
        $this->collator->setStrength(Collator::QUATERNARY);

        return $this;
    }

    public function identicalStrength(): self
    {
        $this->collator->setStrength(Collator::IDENTICAL);

        return $this;
    }

    public function orderByAsc(): self
    {
        $this->isAsc = true;

        return $this;
    }

    public function orderByDesc(): self
    {
        $this->isAsc = false;

        return $this;
    }

    public function orderByKeys(): self
    {
        $this->isKeySort = true;

        return $this;
    }

    public function orderByValues(): self
    {
        $this->isKeySort = false;

        return $this;
    }

    public function nullFirst(): self
    {
        $this->configuration->setNullableSort(Configuration::NULL_VALUES_FIRST);

        return $this;
    }

    public function nullLast(): self
    {
        $this->configuration->setNullableSort(Configuration::NULL_VALUES_LAST);

        return $this;
    }

    public function removeNullPosition(): self
    {
        $this->configuration->setNullableSort(null);

        return $this;
    }

    public function getSorter(): Sorter
    {
        $comparator = $this->getComparator();
        if ($this->isKeySort) {
            $sorter = new Key($comparator);
        } else {
            $sorter = new Asc($comparator);
        }

        if (! $this->isAsc) {
            return new Desc($sorter);
        }

        return $sorter;
    }

    public function getComparator(): Comparable
    {
        return $this->comparatorFactory->create(new ConfigurableCollator($this->collator, $this->configuration));
    }
}
