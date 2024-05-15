<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day01 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '2' => '12';
        yield '2' => '14';
        yield '654' => '1969';
        yield '33583' => '100756';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '2' => '14';
        yield '966' => '1969';
        yield '50346' => '100756';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $sum = 0;
        foreach ($input as $item) {
            $mass = intval($item);
            $s = $this->massCalc($mass);
            $sum += $s;
        }
        return (string)$sum;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $sum = 0;
        foreach ($input as $item) {
            $mass = intval($item);
            $s = $this->massCalc($mass, true);
            $sum += $s;
        }
        return (string)$sum;
    }

    private function massCalc($val, $all = false): float | bool | int
    {
        $sum = floor($val / 3) - 2;
        if ($sum <= 0) {
            return 0;
        }
        if ($all == true) {
            $a = $this->massCalc($sum);
            $sum += $a;
            while ($a > 0) {
                $a = $this->massCalc($a);
                $sum += $a;
            }
        }
        return $sum;
    }
}
