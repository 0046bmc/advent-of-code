<?php

declare(strict_types=1);

namespace App\Event\Year2021;

use App\AoC\DayBase;
use App\AoC\DayInterface;
use App\Map2D;

class Day15 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '40' => '1163751742
1381373672
2136511328
3694931569
7463417111
1319128137
1359912421
3125421639
1293138521
2311944581
';
    }

    public function testPart2(): iterable
    {
        return [];
    }

    public function solvePart1(string $input): string
    {
        $map = Map2D::createFromString($input);
        $map->defaultGridValue = false;
        $d = $map->getLowestNeighbors(0, 0);
        var_dump($d);
        return '2';
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        return '';
    }
}
