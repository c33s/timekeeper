<?php

namespace Phpactor\Extension\Timekeeper\Adapter\Hoa;

use Hoa\Compiler\Exception\Exception;
use Hoa\Compiler\Exception\UnrecognizedToken;
use Hoa\Compiler\Llk\Llk;
use Hoa\File\Read;
use Phpactor\Extension\Timekeeper\Domain\Exception\CouldNotLoadTimesheet;
use Phpactor\Extension\Timekeeper\Domain\Timesheet;
use Phpactor\Extension\Timekeeper\Domain\TimesheetLoader;
use Phpactor\TextDocument\Util\LineAtOffset;

class HoaTimesheetLoader implements TimesheetLoader
{
    public function load(string $document): Timesheet
    {
        $compiler = Llk::load(new Read(__DIR__ . '/../../../resources/timesheet.pp'));
        try {
            $ast = $compiler->parse($document);
        } catch (UnrecognizedToken $hoaException) {
            $this->formatUnrecognizedToken($hoaException, $document);
        } catch (Exception $exception) {
            throw new CouldNotLoadTimesheet($hoaException->getMessage(), $hoaException->getCode(), $hoaException);
        }

        $walker = new TimesheetWalker();

        return $walker->walk($ast);
    }

    private function formatUnrecognizedToken(UnrecognizedToken $hoaException, string $document)
    {
        $offset = $hoaException->getColumn();
        $line = '    ' . (new LineAtOffset())->__invoke($document, $offset);
        $message = (new LineAtOffset())->__invoke($hoaException->getMessage(), 0);


        throw new CouldNotLoadTimesheet(implode(PHP_EOL, [
            $message, $line
        ]));
    }
}
