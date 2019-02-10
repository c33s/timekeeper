<?php

namespace Phpactor\Extension\Timekeeper\Domain\Builder;

use DateTimeImmutable;

class Date
{
    /**
     * @var DateTimeImmutable
     */
    private $date;

    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }
}
