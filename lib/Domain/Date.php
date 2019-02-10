<?php

namespace Phpactor\Extension\Timekeeper\Domain;

use ArrayIterator;
use DateTimeImmutable;
use IteratorAggregate;

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
}
