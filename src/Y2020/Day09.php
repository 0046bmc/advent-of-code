<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day09 extends DayBase implements DayInterface
{
    private string $firstMatch = '';
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '127' => $this->getTestInput();
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '62' => $this->getTestInput();
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $preample = ($this->isTest == true) ? 5 : 25;
        foreach (range($preample, count($input) - 1) as $i) {
            $b = $input;
            $test = array_splice($b, $i - $preample, $preample);
            $nr = $input[$i];

            if (!$this->aSUm($nr, $test)) {
                $this->firstMatch = $nr;
                return (string)$nr;
            }
        }
        return '';
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $preample = ($this->isTest == true) ? 5 : 25;
        $max = count($input);
        foreach (range(0, $max - 1) as $i) {
            for ($x = 1; $x < ($max - $i); $x++) {
                if ($x > $preample) {
                    break;
                }
                $b = $input;
                $test = array_splice($b, $i, $x);
                $sum = array_sum($test);
                if ($sum > intval($this->firstMatch)) {
                    break;
                }
                if ($sum == $this->firstMatch) {
                    return (string)(min($test) + max($test));
                }
            }
        }
        return '';
    }

    public function aSUm($nr, $ar): bool
    {
        foreach ($ar as $xi => $x) {
            foreach ($ar as $yi => $y) {
                if ($xi == $yi) {
                    continue;
                }
                if (($x + $y) == $nr) {
                    return true;
                }
            }
        }
        return false;
    }
}
