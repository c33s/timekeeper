<?php

namespace Phpactor\Extension\Timekeeper;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\Extension\Console\ConsoleExtension;
use Phpactor\Extension\Timekeeper\Console\ReportCommand;
use Phpactor\MapResolver\Resolver;

class TimekeeperExtension implements Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(ContainerBuilder $container)
    {
        $container->register('timekeeper.console.report', function (Container $container) {
            return new ReportCommand();
        }, [ ConsoleExtension::TAG_COMMAND => [ 'name' => 'time:report']]);
    }

    /**
     * {@inheritDoc}
     */
    public function configure(Resolver $schema)
    {
    }
}
