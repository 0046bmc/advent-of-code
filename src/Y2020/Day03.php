<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Map2D;

class Day03 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '7' => $this->getTestInput();
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '336' => $this->getTestInput();
    }

    public function solvePart1(string $input): string
    {
        $b = Map2D::createFromString($input);
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
        $b = Map2D::createFromString($input);
        $ret = 1;
        foreach ($slopes as $slope) {
            $ret = $ret * $b->countInPath([$slope[0], $slope[1]]);
        }
        return (string)$ret;
    }
}
