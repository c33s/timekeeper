<?php

namespace Phpactor\Extension\Timekeeper\Domain;

class Timesheet
{
    /**
     * @var Date[]
     */
    private $dates;

    public function __construct(array $dates)
    {
        $this->dates = $dates;
    }
}
