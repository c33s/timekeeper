<?php

namespace Phpactor\Extension\Timekeeper\Domain;

use DateTimeImmutable;

class Date
{
    /**
     * @var DateTimeImmutable
     */
    private $date;

    /**
     * @var Entry[]
     */
    private $entries;

    public function __construct(DateTimeImmutable $date, array $entries)
    {
        $this->date = $date;
        $this->entries = $entries;
    }
}
