<?php

namespace Phpactor\Extension\Timekeeper\Tests\Integration;

use Hoa\Compiler\Llk\Llk;
use Hoa\File\Read;
use PHPUnit\Framework\TestCase;
use Phpactor\Extension\Timekeeper\Adapter\Hoa\HoaTimesheetLoader;

class HoaTimesheetLoaderTest extends TestCase
{
    /**
     * @dataProvider provideDocuments
     */
    public function testLoad(string $string)
    {
        $loader = (new HoaTimesheetLoader());
        $timesheet = $loader->load($string);
        $this->addToAssertionCount(1);
    }

    public function provideDocuments()
    {
        yield [
            '2019-01-01'
        ];

        yield [
            <<<'EOT'
2019-01-01

EOT
        ];

        yield 'time and text' => [
            <<<'EOT'
2019-01-01
10:00 Fo

EOT
        ];

        yield 'category' => [
            <<<'EOT'
2019-01-01
10:00 [cat1]

EOT
        ];

        yield 'category and text' => [
            <<<'EOT'
2019-01-01
10:00 [cat1] Fo

EOT
        ];

        yield '@tag' => [
            <<<'EOT'
2019-01-01
10:00 @hello

EOT
        ];

        yield '@tags' => [
            <<<'EOT'
2019-01-01
10:00 @hello @bar

EOT
        ];

        yield 'full entry' => [
            <<<'EOT'
2019-01-01
10:00 [AA-1234] This is something I did @pairing @foobar @barfoo

EOT
        ];

        yield 'multi entry' => [
            <<<'EOT'
2019-01-01
10:00 [AA-1234] This is something I did
12:00 [AA-4345] This is something I did @pairing @foobar @barfoo

EOT
        ];

        yield 'multi date' => [
            <<<'EOT'
2019-01-01
10:00 [AA-1234] One
12:00 [AA-4345] Two @pairing @foobar @barfoo

2020-01-01
10:00 [AA-1234] One
12:00 [AA-4345] Two @pairing @foobar @barfoo
EOT
        ];
    }
}
