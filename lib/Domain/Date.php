<?php

namespace Phpactor\Extension\Timekeeper\Domain;

use ArrayIterator;
use DateInterval;
use DateTimeImmutable;
use IteratorAggregate;
use RuntimeException;

class Date implements IteratorAggregate
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

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->entries);
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function calculateDuration(Entry $entry, int $maxHoursInDay = 8): DateInterval
    {
        $next = $this->nextEntry($entry);
        $start = $this->date->setTime($entry->hour(), $entry->minutes());

        if ($next) {
            $end = $this->date->setTime($next->hour(), $next->minutes());
        } else {
            $firstEntry = $this->firstEntry();
            $end = $this->date->setTime($firstEntry->hour(), $firstEntry->minutes())->modify(sprintf('+%s hours', $maxHoursInDay));
        }

        return $start->diff($end);
    }

    private function nextEntry(Entry $targetEntry): ?Entry
    {
        $returnNext = false;
        foreach ($this->entries as $entry) {
            if ($entry === $targetEntry) {
                $returnNext = true;
                continue;
            }

            if ($returnNext) {
                return $entry;
            }
        }

        return null;
    }

    private function firstEntry(): Entry
    {
        foreach ($this->entries as $entry) {
            return $entry;
        }

        throw new RuntimeException(
            'No entries'
        );
    }
}
