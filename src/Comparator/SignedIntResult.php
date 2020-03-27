<?php

declare(strict_types=1);

namespace Budgegeria\IntlSort\Comparator;

class SignedIntResult implements Result
{
    /**
     * @var int
     */
    private $compareResult;

    public function __construct(int $compareResult)
    {
        $this->compareResult = $compareResult;
    }

    public function isSame(): bool
    {
        return $this->compareResult === 0;
    }

    public function isGreater(): bool
    {
        return $this->compareResult === 1;
    }

    public function isLess(): bool
    {
        return $this->compareResult === -1;
    }
}