<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Tests;

use Budgegeria\IntlSort\Collator\Collator as IntlSortCollator;
use Budgegeria\IntlSort\Collator\ConfigurableCollator;
use Budgegeria\IntlSort\Collator\Configuration;
use Collator as IntlCollator;

trait Collator
{
    private function createCollator(?IntlCollator $collator = null): IntlSortCollator
    {
        if ($collator === null) {
            $collator = new IntlCollator('en_US');
        }

        return new ConfigurableCollator($collator, new Configuration());
    }
}
