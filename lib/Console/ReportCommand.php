<?php

namespace Phpactor\Extension\Timekeeper\Console;

use Phpactor\Extension\Timekeeper\Adapter\Hoa\HoaTimesheetLoader;
use Phpactor\Extension\Timekeeper\Domain\Date;
use Phpactor\Extension\Timekeeper\Domain\Timesheet;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReportCommand extends Command
{
    public function configure()
    {
        $this->setName('time:report');
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to timesheet');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $timesheet = $this->loadTimesheet($path);

        $table = new Table($output);
        $table->setHeaders(['date', 'time', 'category', 'duration', 'description', 'tags']);

        foreach ($timesheet as $date) {
            foreach ($date as $entry) {
                assert($date instanceof Date);
                $table->addRow([
                    $date->date()->format('Y-m-d'),
                    $entry->time(),
                    sprintf('<info>%s</>', $entry->category()),
                    $date->calculateDuration($entry)->format('%hh %im'),
                    trim($entry->comment()),
                    $this->formatTags($entry->tags())
                ]);
            }
        }

        $table->render();
    }

    private function loadTimesheet(string $path): Timesheet
    {
        if (!file_exists($path)) {
            throw new RuntimeException(sprintf(
                'File "%s" does not exist', $path
            ));
        }

        if (!is_readable($path)) {
            throw new RuntimeException(sprintf(
                'File "%s" is not readable', $path
            ));
        }

        $contents = file_get_contents($path);

        if (false === $contents) {
            throw new RuntimeException(sprintf(
                'Could not open file "%s"', $path
            ));
        }

        $loader = new HoaTimesheetLoader();

        return $loader->load($contents);
    }

    private function formatTags(array $tags): string
    {
        return implode(',', array_map(function (string $tag) {
            return sprintf('<comment>@%s</>', $tag);
        }, $tags));
    }
}
