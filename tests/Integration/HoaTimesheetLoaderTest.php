<?php

namespace Phpactor\Extension\Timekeeper\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Phpactor\Extension\Timekeeper\Adapter\Hoa\HoaTimesheetLoader;
use Phpactor\Extension\Timekeeper\Domain\Builder\DateBuilder;
use Phpactor\Extension\Timekeeper\Domain\Builder\EntryBuilder;
use Phpactor\Extension\Timekeeper\Domain\Builder\TimesheetBuilder;
use Phpactor\Extension\Timekeeper\Domain\Timesheet;

class HoaTimesheetLoaderTest extends TestCase
{
    /**
     * @dataProvider provideDocuments
     */
    public function testLoad(string $string, Timesheet $expected)
    {
        $loader = (new HoaTimesheetLoader());
        $timesheet = $loader->load($string);
        $this->assertEquals($expected, $timesheet);
    }

    public function provideDocuments()
    {
        yield [
            '2019-01-01',
            TimesheetBuilder::create()->addDate(
                DateBuilder::fromString('2019-01-01')->build()
            )->build()
        ];

        yield 'time and text' => [
            <<<'EOT'
2019-01-01
10:00 Fo

EOT
            , TimesheetBuilder::create()->addDate(
                DateBuilder::fromString('2019-01-01')
                    ->addEntry(EntryBuilder::fromTime('10:00')->comment('Fo')->build())
                    ->build()
            )->build()
        ];

        yield 'category' => [
            <<<'EOT'
2019-01-01
10:00 [cat1]

EOT
            , TimesheetBuilder::create()->addDate(
                DateBuilder::fromString('2019-01-01')
                    ->addEntry(EntryBuilder::fromTime('10:00')->category('cat1')->build())
                    ->build()
            )->build()
        ];

        yield '@tag' => [
            <<<'EOT'
2019-01-01
10:00 @hello

EOT
            , TimesheetBuilder::create()->addDate(
                DateBuilder::fromString('2019-01-01')
                    ->addEntry(EntryBuilder::fromTime('10:00')->addTag('hello')->build())
                    ->build()
            )->build()
        ];

        yield '@tags' => [
            <<<'EOT'
2019-01-01
10:00 @hello @bar

EOT
            , TimesheetBuilder::create()->addDate(
                DateBuilder::fromString('2019-01-01')
                    ->addEntry(EntryBuilder::fromTime('10:00')
                        ->addTag('hello')
                        ->addTag('bar')
                        ->build())
                    ->build()
            )->build()
        ];

        yield 'multi entry' => [
            <<<'EOT'
2019-01-01
10:00 [AA-1234] This is something I did
12:00 [AA-4345] This is something I did @pairing @foobar @barfoo

EOT
            , TimesheetBuilder::create()->addDate(
                DateBuilder::fromString('2019-01-01')
                    ->addEntry(EntryBuilder::fromTime('10:00')
                        ->category('AA-1234')
                        ->comment('This is something I did')
                        ->build())
                    ->addEntry(EntryBuilder::fromTime('12:00')
                        ->comment('This is something I did')
                        ->category('AA-4345')
                        ->addTag('pairing')
                        ->addTag('foobar')
                        ->addTag('barfoo')
                        ->build())
                    ->build()
            )->build()
        ];
    }
}
