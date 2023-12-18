<?php

declare(strict_types=1);

namespace App\Y2023;

use App\Map2D;
use App\Y2023\Helpers\MirrorRunner;
use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day16 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '46' => file_get_contents(__DIR__ . '/Inputs/day16.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '51' => file_get_contents(__DIR__ . '/Inputs/day16.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $MR = new MirrorRunner($input);

        $start = [0, 0];
        $dir = 1;

        $ret = $MR->run($start, $dir);

        return (string)$ret;
    }

    public function solvePart2(string $input): string
    {
        $MR = new MirrorRunner($input);
        $counts = [];
        for ($y = 0; $y < $MR->maxY; $y++) {
            $counts[] = $MR->run([0, $y], 1);
            $counts[] = $MR->run([$MR->maxX, $y], 3);
        }
        for ($x = 0; $x < $MR->maxX; $x++) {
            $counts[] = $MR->run([$x, 0], 2);
            $counts[] = $MR->run([$x, $MR->maxY], 0);
        }

        return (string)max($counts);
    }
}
