<?php

namespace Phpactor\Extension\Timekeeper\Domain\Builder;

use DateTimeImmutable;
use Phpactor\Extension\Timekeeper\Domain\Entry;
use Phpactor\Extension\Timekeeper\Domain\Date;

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
        return new Date($this->date, $this->entries);
    }

    public function date(DateTimeImmutable $date)
    {
        $this->date = $date;
        return $this;
    }

    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;
        return $this;
    }

    public static function fromString(string $string): self
    {
        $new = new self();
        $new->date = new DateTimeImmutable($string);

        return $new;
    }
}
