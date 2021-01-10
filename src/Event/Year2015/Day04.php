<?php

declare(strict_types=1);

namespace App\Event\Year2015;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day04 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '609043' => 'abcdef';
    }

    public function testPart2(): iterable
    {
        return [];
    }

    public function solvePart1(string $input): string
    {
        $input = chop($input);
        $i = $this->findMd5($input, 5);
        return (string)$i;
    }

    public function solvePart2(string $input): string
    {
        $input = chop($input);
        $i = $this->findMd5($input, 6);
        return (string)$i;
    }

    /**
     * @param string $input
     * @param int $zeros
     * @return int
     */
    private function findMd5(string $input, int $zeros): int
    {
        $start = str_repeat('0', $zeros);
        $i = 0;
        while (true) {
            $res = md5($input . ($i));
            if (str_starts_with($res, $start)) {
                break;
            }
            $i++;
        }
        return $i;
    }
}
