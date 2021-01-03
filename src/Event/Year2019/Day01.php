<?php

declare(strict_types=1);

namespace App\Event\Year2019;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day01 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '2' => '12';
        yield '2' => '14';
        yield '4' => '12
14';
        yield '654' => '1969';
        yield '33583' => '100756';
    }

    public function testPart2(): iterable
    {
        yield '2' => '14';
        yield '966' => '1969';
        yield '50346' => '100756';
    }

    public function solvePart1(string $input): string
    {
        $input = explode("\n", chop($input));
        $sum = 0;
        foreach ($input as $item) {
            $sum += (int)($item / 3) - 2;
        }
        return (string)$sum;
    }

    public function solvePart2(string $input): string
    {
        $input = explode("\n", chop($input));
        $sum = 0;
        foreach ($input as $item) {
            $val = (int)($item / 3) - 2;
            while ($val > 0) {
                $sum += $val;
                $val = (int)($val / 3) - 2;
            }
        }
        return (string)$sum;
    }
}