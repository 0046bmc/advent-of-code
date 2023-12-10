<?php

declare(strict_types=1);

namespace App\Y2021;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day07 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '37' => '16,1,2,0,4,2,7,1,2,14';
    }

    public function testPart2(): iterable
    {
        yield '168' => '16,1,2,0,4,2,7,1,2,14';
    }

    public function solvePart1(string $input): string
    {
        $input = array_map('intval', explode(',', chop($input)));
        return (string)$this->fuelCalc($input);
    }

    public function solvePart2(string $input): string
    {
        $input = array_map("intval", explode(",", trim($input)));
        return (string)$this->fuelCalc($input, true);
    }

    public function fuelCalc($input, $isFib = false)
    {
        $used = PHP_INT_MAX;
        list($minPos, $maxPos) = [min($input), max($input)];
        for ($i = $minPos; $i < $maxPos; $i++) {
            $stepUsage = 0;
            foreach ($input as $pos) {
                $move = abs($pos - $i);
                $stepUsage += $isFib ? ($move * ($move + 1)) / 2 : $move;
            }
            if ($stepUsage < $used) {
                $used = $stepUsage;
            }
        }
        return $used;
    }
}
