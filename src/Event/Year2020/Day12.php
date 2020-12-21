<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use App\Event\Year2020\Helpers\Boat;

class Day12 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '25' => 'F10
N3
F7
R90
F11';
    }

    public function testPart2(): iterable
    {
        yield '286' => 'F10
N3
F7
R90
F11';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $b = new Boat($input);
        return (string)$b->dist;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $b = new Boat($input, true);
        return (string)$b->dist;
    }
}
