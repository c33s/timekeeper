<?php

namespace Phpactor\Extension\Timekeeper\Tests\Unit\Domain;

use DateInterval;
use PHPUnit\Framework\TestCase;
use Phpactor\Extension\Timekeeper\Domain\Builder\DateBuilder;
use Phpactor\Extension\Timekeeper\Domain\Builder\EntryBuilder;

class DateTest extends TestCase
{
    public function testCalculatesDurationOfNonBoundedEntryWhenNextEntryExists()
    {
        $builder = DateBuilder::fromString('2018-01-01');
        $target = EntryBuilder::fromTime('10:00')->build();
        $builder->addEntry($target);
        $builder->addEntry(EntryBuilder::fromTime('12:00')->build());

        $duration = $builder->build()->calculateDuration($target);
        $this->assertInstanceOf(DateInterval::class, $duration);
        $this->assertEquals('2h0m', $duration->format('%hh%im'));
    }

    public function testCalculatesDurationOfNonBoundedEntryWhenNextEntryNotExisting()
    {
        $builder = DateBuilder::fromString('2018-01-01');
        $target = EntryBuilder::fromTime('10:00')->build();
        $builder->addEntry($target);

        $duration = $builder->build()->calculateDuration($target);
        $this->assertInstanceOf(DateInterval::class, $duration);
        $this->assertEquals('8h0m', $duration->format('%hh%im'));
    }
}
