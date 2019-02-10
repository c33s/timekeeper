<?php

namespace Phpactor\Extension\Timekeeper\Domain\Builder;

use Phpactor\Extension\Timekeeper\Domain\Timesheet;
use Phpactor\Extension\Timekeeper\Domain\Date;

class TimesheetBuilder
{
    private $dates = [];

    public function addDate(Date $date): self
    {
        $this->dates[] = $date;
        return $this;
    }

    public function build(): Timesheet
    {
        return new Timesheet($this->dates);
    }

    public static function create(): self
    {
        return new self();
    }
}
