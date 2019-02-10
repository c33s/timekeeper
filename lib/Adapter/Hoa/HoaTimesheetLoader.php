<?php

namespace Phpactor\Extension\Timekeeper\Adapter\Hoa;

use Hoa\Compiler\Llk\Llk;
use Hoa\File\Read;
use Phpactor\Extension\Timekeeper\Domain\Timesheet;
use Phpactor\Extension\Timekeeper\Domain\TimesheetLoader;

class HoaTimesheetLoader implements TimesheetLoader
{
    public function load(string $document): Timesheet
    {
        $compiler = Llk::load(new Read(__DIR__ . '/../../../resources/timesheet.pp'));
        $ast = $compiler->parse($document);

        $walker = new TimesheetWalker();

        return $walker->walk($ast);
    }
}
