<?php

declare(strict_types=1);

namespace App\Y2023;

use App\Map2D;
use App\Y2023\Helpers\MazeRunner;
use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day10 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '4' => '-L|F7
7S-7|
L|7||
-L-J|
L|-JF';
        yield '8' => '7-F7-
.FJ|7
SJLL7
|F--J
LJ.LJ';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '4' => file_get_contents(__DIR__ . '/Inputs/day10.test1.txt');
        yield '8' => file_get_contents(__DIR__ . '/Inputs/day10.test2.txt');
    }

    public function solvePart1(string $input): string
    {
        $G = new MazeRunner($input);
        return (string)$G->walk();
    }

    public function solvePart2(string $input): string
    {
        $G = new MazeRunner($input);
        return (string)$G->walk(true);
    }
}
