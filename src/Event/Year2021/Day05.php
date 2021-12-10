<?php

declare(strict_types=1);

namespace App\Event\Year2021;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use mahlstrom\Map2D;

class Day05 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '5' => '0,9 -> 5,9
8,0 -> 0,8
9,4 -> 3,4
2,2 -> 2,1
7,0 -> 7,4
6,4 -> 2,0
0,9 -> 2,9
3,4 -> 1,4
0,0 -> 8,8
5,5 -> 8,2';
    }

    public function testPart2(): iterable
    {
        yield '12' => '0,9 -> 5,9
8,0 -> 0,8
9,4 -> 3,4
2,2 -> 2,1
7,0 -> 7,4
6,4 -> 2,0
0,9 -> 2,9
3,4 -> 1,4
0,0 -> 8,8
5,5 -> 8,2';
    }

    public function solvePart1(string $input): string
    {
        $O = new Map2D();
        $input = $this->parseInput($input);
        foreach ($input as $item) {
            $cc = sscanf($item, '%d,%d -> %d,%d');
            if ($cc[0] == $cc[2] || $cc[1] == $cc[3]) {
                $O->drawLine([$cc[0], $cc[1]], [$cc[2], $cc[3]]);
            }
        }

        return (string)array_count_values($O->c)[2];
    }

    public function solvePart2(string $input): string
    {
        $O = new Map2D();
        $input = $this->parseInput($input);
        foreach ($input as $item) {
            $cc = sscanf($item, '%d,%d -> %d,%d');
            $O->drawLine([$cc[0], $cc[1]], [$cc[2], $cc[3]]);
        }

        return (string)array_count_values($O->c)[2];
    }
}
