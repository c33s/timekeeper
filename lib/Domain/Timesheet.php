<?php

namespace Phpactor\Extension\Timekeeper\Domain;

use IteratorAggregate;

class Timesheet implements IteratorAggregate
{
    /**
     * @var Date[]
     */
    private $dates;

    public function __construct(array $dates)
    {
        $this->dates = $dates;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->dates);
    }
}
