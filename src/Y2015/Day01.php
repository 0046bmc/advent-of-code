<?php

declare(strict_types=1);

namespace App\Y2015;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day01 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '0' => '(())';
        yield '0' => '()()';
        yield '3' => '(((';
        yield '3' => '(()(()(';
        yield '3' => '))(((((';
        yield '-1' => '())';
        yield '-1' => '))(';
        yield '-3' => ')))';
        yield '-3' => ')())())';
    }

    public function testPart2(): iterable
    {
        yield '1' => ')';
        yield '5' => '()())';
    }

    public function solvePart1(string $input): string
    {
        $input = str_split(chop($input));

        $d = array_count_values($input);
        return ((isset($d['('])) ? $d['('] : 0) - ((isset($d[')'])) ? $d[')'] : 0) . '';
    }

    public function solvePart2(string $input): string
    {
        $input = str_split(chop($input));
        $i = 1;
        $floor = 0;
        foreach ($input as $d) {
            $floor = ($d == '(') ? $floor + 1 : $floor - 1;
            if ($floor < 0) {
                return (string)$i;
            }
            $i++;
        }

        return '';
    }
}
