<?php

declare(strict_types=1);

namespace App\Event\Year2018;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day01 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '3' => "+1\n+1\n+1";
        yield '0' => "+1\n+1\n-2";
        yield '-6' => "-1\n-2\n-3";
    }

    public function testPart2(): iterable
    {
        yield '0' => "+1\n-1";
        yield '10' => "+3\n+3\n+4\n-2\n-4";
        yield '5' => "-6\n+3\n+8\n+5\n-6";
        yield '14' => "+7\n+7\n-2\n-7\n-4";
    }

    public function solvePart1(string $input): string
    {
        $input = explode("\n", $input);

        return (string)array_sum($input);
    }

    public function solvePart2(string $input): string
    {
        $input = explode("\n", $input);
        $freq = 0;
        $mem = [0 => 1];

        while (true) {
            foreach ($input as $line) {
                $freq += (int)$line;

                if (!empty($mem[$freq])) {
                    break 2;
                }

                $mem[$freq] = 1;
            }
        }
        return (string)$freq;
    }
}
