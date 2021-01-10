<?php

declare(strict_types=1);

namespace App\Event\Year2015;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use mahlstrom\Map2D;

class Day03 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '2' => '>';
        yield '4' => '^>v<';
        yield '2' => '^v^v^v^v^v';
    }

    public function testPart2(): iterable
    {
        yield '3' => '^v';
        yield '3' => '^>v<';
        yield '11' => '^v^v^v^v^v';
    }

    public function solvePart1(string $input): string
    {
        $M = str_split(chop($input));
        $x = 0;
        $y = 0;
        $res = new Map2D();
        $res[$y][$x]=1;
        foreach ($M as $d) {
            $x = match ($d) {
                '>' => $x + 1,
                '<' => $x - 1,
                default => $x
            };
            $y = match ($d) {
                'v' => $y + 1,
                '^' => $y - 1,
                default => $y
            };

            $res->setCoord(1, $y, $x);
        }
        return (string)array_sum(Map2D::flatten($res->c));
    }

    public function solvePart2(string $input): string
    {
        $M = str_split(chop($input));
        $x = $y = [0, 0];
        $res = new Map2D();
        $res2 = new Map2D();
        $res[$y[0]][$x[0]]=1;
        $res[$y[1]][$x[1]]=1;
        foreach ($M as $i => $d) {
            $w = $i % 2;
            $x[$w] = match ($d) {
                '>' => $x[$w] + 1,
                '<' => $x[$w] - 1,
                default => $x[$w]
            };
            $y[$w] = match ($d) {
                'v' => $y[$w] + 1,
                '^' => $y[$w] - 1,
                default => $y[$w]
            };
            $res[$y[0]][$x[0]]=1;
            $res2[$y[1]][$x[1]]=1;
        }
        return (string)array_sum(Map2D::flatten($res->c) + Map2D::flatten($res2->c));
    }
}
