<?php

declare(strict_types=1);

namespace App\Y2021;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day06 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '5934' => '3,4,3,1,2';
    }

    public function testPart2(): iterable
    {
        yield '26984457539' => '3,4,3,1,2';
    }

    public function solvePart1(string $input): string
    {
        $fishes = $this->fishInput($input);
        $res = $this->fishDay($fishes, 80);
        return (string)array_sum($res);
    }

    public function solvePart2(string $input): string
    {
        $fishes = $this->fishInput($input);
        $res = $this->fishDay($fishes, 256);
        return (string)array_sum($res);
    }

    /**
     * @param array $fishes
     */
    private function fishDay(array $fishes, $itterations): array
    {
        for ($i = 0; $i < $itterations; $i++) {
            foreach ($fishes as $key => $fish) {
                $fishes[$key - 1] = $fish;
            }
            $fishes[8] = $fishes[-1];
            $fishes[6] += $fishes[-1];
            unset($fishes[-1]);
        }
        return $fishes;
    }

    /**
     * @param string $input
     * @return array
     */
    private function fishInput(string $input): array
    {
        $input = explode(',', chop($input));
        $fishes = array_fill(0, 9, 0);
        foreach ($input as $d) {
            $fishes[$d]++;
        }
        return $fishes;
    }
}
