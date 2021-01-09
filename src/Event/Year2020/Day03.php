<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use mahlstrom\Map2D;

class Day03 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '7' => '..##.......
#...#...#..
.#....#..#.
..#.#...#.#
.#...##..#.
..#.##.....
.#.#.#....#
.#........#
#.##...#...
#...##....#
.#..#...#.#';
    }

    public function testPart2(): iterable
    {
        yield '336' => '..##.......
#...#...#..
.#....#..#.
..#.#...#.#
.#...##..#.
..#.##.....
.#.#.#....#
.#........#
#.##...#...
#...##....#
.#..#...#.#';
    }

    public function solvePart1(string $input): string
    {
        $b = new Map2D($input);
        return (string)$b->countInPath([3, 1]);
    }

    public function solvePart2(string $input): string
    {
        $slopes = [
            [3, 1],
            [1, 1],
            [5, 1],
            [7, 1],
            [1, 2]
        ];
        $b = new Map2D($input);
        $ret = 1;
        foreach ($slopes as $slope) {
            $ret = $ret * $b->countInPath([$slope[0], $slope[1]]);
        }
        return (string)$ret;
    }
}
