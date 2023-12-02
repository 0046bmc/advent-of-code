<?php

declare(strict_types=1);

namespace App\Event\Year2023;

use App\AoC\DayBase;
use App\AoC\DayInterface;

class Day01 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '142' => file_get_contents(__DIR__ . '/TestInputs/Day01.1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '281' => file_get_contents(__DIR__ . '/TestInputs/Day01.2.txt');
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $tot = $this->getIt($input);
        return (string)$tot;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $tot = $this->getIt($input, true);
        return (string)$tot;
    }

    /**
     * @param array<string> $input
     * @return int
     */
    private function getIt(array $input, bool $convert = false): int
    {
        $check = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        if ($convert) {
            $check = array_merge($check, ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine']);
        }
        $tot = 0;
        foreach ($input as $row) {
            $i = [];
            foreach (range(0, strlen($row)) as $pos) {
                foreach ($check as $chpart) {
                    if (str_starts_with(substr($row, $pos), $chpart)) {
                        $i[] = $this->getNumber($chpart);
                    }
                }
            }
            $part = $i[array_key_first($i)] . $i[array_key_last($i)];
            $tot += (int)$part;
        }
        return $tot;
    }

    private function getNumber(string $number): int
    {
        return match ($number) {
            'zero'=>0,
            'one'=>1,
            'two'=>2,
            'three'=>3,
            'four'=>4,
            'five'=>5,
            'six'=>6,
            'seven'=>7,
            'eight'=>8,
            'nine'=>9,
            default => intval($number)
        };
    }
}
