<?php

namespace Phpactor\Extension\Timekeeper\Domain\Builder;

use DateTimeImmutable;
use Phpactor\Extension\Timekeeper\Domain\Entry;

class DateBuilder
{
    /**
     * @var DateTimeImmutable
     */
    private $date;

    /**
     * @var Entry[]
     */
    private $entries = [];

    public function build(): Date
    {
        return new Date($this->date);
    }

    public function date(DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;
    }
}
