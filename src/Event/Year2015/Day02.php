<?php

declare(strict_types=1);

namespace App\Event\Year2015;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day02 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '58' => '4x3x2';
        yield '43' => '1x1x10';
    }

    public function testPart2(): iterable
    {
        yield '34' => '4x3x2';
        yield '14' => '1x1x10';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $tot=0;
        foreach ($input as $r) {
            [$l, $w, $h] = array_map('intval', explode('x',$r));
            $dim=[$l,$w,$h];
            sort($dim);
            $a=2*$l*$w+2*$w*$h+2*$h*$l+$dim[0]*$dim[1];
            $tot+=$a;
        }
        return (string)$tot;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $tot=0;
        foreach ($input as $r) {
            [$l, $w, $h] = array_map('intval', explode('x',$r));
            $dim=[$l,$w,$h];
            sort($dim);
            $a=$dim[0]*2+$dim[1]*2+$l*$w*$h;
            $tot+=$a;
        }
        return (string)$tot;
    }
}
