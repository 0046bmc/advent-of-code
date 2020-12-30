<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use App\Event\Year2020\Helpers\WierdCalc;

class Day18 extends DayBase implements DayInterface
{

    public function testPart1(): iterable
    {
        yield '71' => '1 + 2 * 3 + 4 * 5 + 6';
        yield '51' => '1 + (2 * 3) + (4 * (5 + 6))';
        yield '26' => '2 * 3 + (4 * 5)';
        yield '437' => '5 + (8 * 3 + 9 + 3 * 4 * 3)';
        yield '12240' => '5 * 9 * (7 * 3 * 3 + 9 * 3 + (8 + 6 * 4))';
        yield '13632' => '((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2';
        yield '77' => '1 + (2 * 3) + (4 * (5 + 6))
2 * 3 + (4 * 5)';
    }

    public function testPart2(): iterable
    {
        yield '231' => '1 + 2 * 3 + 4 * 5 + 6';
        yield '51' => '1 + (2 * 3) + (4 * (5 + 6))';
        yield '46' => '2 * 3 + (4 * 5)';
        yield '1445' => '5 + (8 * 3 + 9 + 3 * 4 * 3)';
        yield '669060' => '5 * 9 * (7 * 3 * 3 + 9 * 3 + (8 + 6 * 4))';
        yield '23340' => '((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2';
        yield '97' => '1 + (2 * 3) + (4 * (5 + 6))
2 * 3 + (4 * 5)';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $ret = 0;
        $C = new WierdCalc();
        foreach ($input as $str) {
            $ret += $C->calc(str_replace(' ', '', $str));
        }
        return (string)$ret;
    }

    public function solvePart2(string $input): string
    {
        WierdCalc::$hardcore = true;
        $input = $this->parseInput($input);
        $C = new WierdCalc();
        $ret = 0;
        foreach ($input as $str) {
            $ret += $C->calc(str_replace(' ', '', $str));
        }
        return (string)$ret;
    }

}
