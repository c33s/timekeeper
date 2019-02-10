<?php

namespace Phpactor\Extension\Timekeeper\Tests\Integration\Parser;

use Hoa\Compiler\Llk\Llk;
use Hoa\Compiler\Visitor\Dump;
use Hoa\File\Read;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @dataProvider provideDocuments
     */
    public function testParse(string $string)
    {
        $compiler = Llk::load(new Read(__DIR__ . '/../../../lib/Parser/timesheet.pp'));

        $ast = $compiler->parse($string);
        $dumper = new Dump();
        echo($dumper->visit($ast));
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
