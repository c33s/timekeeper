<?php

namespace Phpactor\Extension\Timekeeper\Domain;

interface TimesheetLoader
{
    public function load(string $document): Timesheet;
}
