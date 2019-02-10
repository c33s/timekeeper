<?php

namespace Phpactor\Extension\Timekeeper\Domain\Builder;

class TimesheetBuilder
{
    private $dates = [];

    public function addDate(Date $date)
    {
        $this->dates[] = $date;
    }
}
