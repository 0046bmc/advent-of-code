<?php

declare(strict_types=1);

namespace App\Y2022;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day01 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '24000' => file_get_contents(__DIR__ . '/Inputs/day01.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '45000' => file_get_contents(__DIR__ . '/Inputs/day01.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $elfs = $this->getCaloriesPerElf($input);
        return (string)array_pop($elfs);
    }

    public function solvePart2(string $input): string
    {
        $elfs = $this->getCaloriesPerElf($input);
        $tot = (int)array_pop($elfs);
        $tot += (int)array_pop($elfs);
        $tot += (int)array_pop($elfs);

        return (string)$tot;
    }

    /**
     * @param string $input
     * @return array<int | float,int>
     */
    private function getCaloriesPerElf(string $input): array
    {
        $in = explode("\n\n", chop($input));
        $elfs = [];
        foreach ($in as $item) {
            $cals = explode("\n", chop($item));
            $elfs[] = array_sum($cals);
        }
        sort($elfs);
        return $elfs;
    }
}
